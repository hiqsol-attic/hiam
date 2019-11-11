# Security

## User revalidation

Client can ask authorization server to revalidate user session for
token is not stolen.

## Additional token request

Can be used to increase privileges e.g. for dangerous actions.

## Global logout


## Password recovery (aka forgot password)

Security questions should be asked.
After successful password recovery all user sessions (besides the current one)
must be invlidated.
