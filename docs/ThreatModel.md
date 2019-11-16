# Threat model

- stolen credentials (password & 2FA)
    - don't allow intruder change email
    - user will be able to change password and 2FA
- stolen access to email
    - intruder can restore password but cannot login
      because of second factor
- stolen session token
    - binding session with IP and browser fingerprint
- password bruteforcing
    - rate limiting
- social engineering
    - pretending user to steal access to account

## User identity components

- Used for session:
    - Login
    - Email
    - Password
    - TOTP (aka 2FA)
    - IP address
    - Browser fingerprint
- Additional:
    - Security questions
    - PIN-code
    - Person identification documents:
        - ID card
    - Payment details

## Session security

Every user session is associated with:

- IP address
- Browser fingerprint

## Global logout

