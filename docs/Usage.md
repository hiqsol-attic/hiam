# Usage

## User pages

- Log in:                       `/site/login`
- Log out:                      `/site/logout`
- Sign up:                      `/site/signup`
- Restore password:             `/site/restore-password`
- Change email:                 `/site/change-email`
- Change password:              `/site/change-password`
- Resend verification email:    `/site/resend-verification-email`
- [TOTP]:
    - Enable:                   `/mfa/totp/enable`
    - Disable:                  `/mfa/totp/disable`

[TOTP]: https://en.wikipedia.org/wiki/Time-based_One-time_Password_algorithm

## Return URL

Return URL is used to return user back to an application (main site)
after performing needed actions at authorization server,
e.g. after logging in or changing password.

Return URL can be provided in two different ways:

- with `redirect_uri` parameter provided within OAuth2 Authorization Code Request,
  usually used during login procedure
- with `back` POST or GET request parameter within any request, usually used for
  everything besides login, e.g. change email:
  `https://hiam.hipanel.com/site/change-email?back=https://my.domain.com/some/page`

## Swagger/OpenAPI specification

OpenAPI specification is available:

- statically at GitHub: https://github.com/hiqdev/hiam/blob/master/openapi.yaml
- at every installation by the url: /site/openapi.yaml
- at Swagger UI: https://any.swagger.hiqdev.com/?url=https://hiam.hipanel.com/site/openapi.yaml

## OAuth2 entry points

- Authorization code request URL:	`/oauth/authorize`
- Access token request URL:			`/oauth/token`
- User Info request URL:			`/userinfo`

Example Grafana configuration:

```ini
client_id = grafana
client_secret = ***
scopes = email profile
auth_url = https://hiam.hipanel.com/oauth/authorize
token_url = https://hiam.hipanel.com/oauth/token
api_url = https://hiam.hipanel.com/userinfo
```

## Authorization code request

Authorization code request uses standard OAuth2 parameters:

- `client_id`
- `redirect_uri`
- `response_type`
- `state`
- `scope`, available scopes:
    - `email`
    - `profile`
    - `roles`

### Prefer signup

When it is known that users to be sent to authorization are new then
nonempty `prefer_signup` GET parameter can be added to authorization code request.
Then nonauthorized users will be redirected to signup page instead of login.

## Access token request

Access token request uses standard OAuth2 parameters:

- `client_id`
- `client_secret`
- `redirect_uri`
- `grant_type`
- `code`

Access token response provides standard fields:

- `access_token`
- `expires_in`
- `refresh_token`
- `scope`
- `token_type`

and `user_attributes` payload:

```json
{
    "access_token": "4fb0a78633fd7781b6fb645ed5ba908c1810ee81",
    "expires_in": 86400,
    "refresh_token": "adb631f49614ea5f1d1c1d704053d16fde7951b8",
    "scope": null,
    "token_type": "Bearer",
    "user_attributes": {
        "id": 1234567,
        "username": "jsmith",
        "email": "john@smith.me",
        "email_confirmed": "john@smith.me",
        "type": "client",
        "state": "ok",
        "first_name": "John",
        "last_name": "Smith",
        "verified": "1"
    }
}
```

## User info request

User info request must provide HTTP Authorization Bearer header with token.

Example request:

```
GET https://hiam.hipanel.com/userinfo
Authorization: Bearer be2911ab56ffedf74da3090b0bb1b0a56d07c5b9
```

Example response for `email` scope:

```json
{
  "email": "sol@hiqdev.com",
  "email_confirmed": "sol@hiqdev.com",
  "sub": "1000361"
}
```

- `sub` - user identifier (subject)
- `email` - current user email
- `email_confirmed` - last confirmed user email
    - if matches `email` then the email is confirmed
    - else user has changed his email and has not confirmed it yet

## Available grant types

The authorization server provides all standard grant types:

- `authorization_code`
- `client_credentials`
- `refresh_token`
- `password`
- `implicit`

## OAuth2 Requests Demo

There is built-in demo where you can try out OAuth2 requests.
Demo is available at `/demo` page.
Forms are prefetched with reasonable defaults.

## Notification callbacks

Applications can register notification callbacks which will be called on
user change events such as user modified, user deleted, user logged out.

Registered callbacks will be called with HTTP POST request with parameters:

- id - user ID, integer e.g. 1234567
- action - event name, string:
    - insert
    - update
    - delete
    - logout
