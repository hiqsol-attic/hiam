# Threat model

- stolen credentials (password & 2FA)
- stolen access to email
- stolen session token
- password bruteforcing
- social engineering
    - 

## User identity components

- Used for session:
    - Login
    - Email
    - Password
    - TOTP (aka 2FA)
    - IP address
    - Browser fingerprint
- Additional:
    - PIN-code
    - Person identification documents:
        - ID card
    - Payments performed

## Session security

Every user session is associated with:

- IP address
- Browser fingerprint


## Global logout


