#!/usr/bin/env python3
"""End-to-end smoke test for the R.O.S MATE PHP application."""
from __future__ import annotations

import http.cookiejar
import re
import sys
import urllib.parse
import urllib.request
import uuid

BASE = sys.argv[1].rstrip("/") if len(sys.argv) > 1 else "http://127.0.0.1:8000"
COOKIE_JAR = http.cookiejar.CookieJar()
OPENER = urllib.request.build_opener(urllib.request.HTTPCookieProcessor(COOKIE_JAR))


def request(path: str, data: dict[str, str] | None = None) -> tuple[str, str, int]:
    url = BASE + path
    payload = urllib.parse.urlencode(data).encode() if data is not None else None
    req = urllib.request.Request(url, data=payload, method="POST" if payload is not None else "GET")
    if payload is not None:
        req.add_header("Content-Type", "application/x-www-form-urlencoded")
    with OPENER.open(req, timeout=10) as response:
        return response.geturl(), response.read().decode("utf-8", errors="replace"), response.status


def csrf(body: str) -> str:
    match = re.search(r"""name=["']csrf_token["']\s+value=["']([^"']+)""", body)
    if not match:
        raise AssertionError("CSRF token field was not found in the form.")
    return match.group(1)


def check(condition: bool, message: str) -> None:
    if not condition:
        raise AssertionError(message)
    print(f"PASS: {message}")


def main() -> None:
    email = f"ci-smoke-{uuid.uuid4().hex}@example.invalid"
    _, home, status = request("/index.php")
    check(status == 200 and "R.O.S MATE" in home, "homepage responds successfully")

    _, registration, _ = request("/registration.php")
    _, result, _ = request("/registration.php", {
        "csrf_token": csrf(registration),
        "fullname": "CI Smoke Test",
        "email": email,
        "password": "SmokeTest-Only-2026!",
        "repeat_password": "SmokeTest-Only-2026!",
    })
    check("Sign in" in result or "Login" in result, "new account registration completes")

    _, login, _ = request("/login.php")
    login_url, dashboard, _ = request("/login.php", {
        "csrf_token": csrf(login),
        "email": email,
        "password": "SmokeTest-Only-2026!",
    })
    check(login_url.endswith("/dashboard.php") and "CI Smoke Test" in dashboard,
          "login creates an authenticated dashboard session")

    _, contact, _ = request("/P1_contact.php")
    _, contact_result, _ = request("/registrationc.php", {
        "csrf_token": csrf(contact),
        "fullname": "CI Smoke Test",
        "email": email,
        "message": "Automated contact form smoke test.",
    })
    check("sent successfully" in contact_result.lower(),
          "contact form accepts and stores a valid message")

    _, dashboard_page, _ = request("/dashboard.php")
    _, logout_result, _ = request("/logout.php", {"csrf_token": csrf(dashboard_page)})
    check("R.O.S MATE" in logout_result, "logout completes and redirects")

    final_url, _, _ = request("/dashboard.php")
    check(final_url.endswith("/login.php"), "dashboard rejects access after logout")


if __name__ == "__main__":
    try:
        main()
    except Exception as exc:
        print(f"SMOKE TEST FAILED: {exc}", file=sys.stderr)
        raise
