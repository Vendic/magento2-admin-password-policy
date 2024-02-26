# Vendic_AdminPasswordPolicy

This module adds additional rules for admin passwords. It ensures that the following criteria are met for admin passwords:

- Password does not contain first name, last name, username or email of the user.
- Password does not contain 'guest', 'admin', or 'password'.
- Password has at least one lowercase letter.
- Password has at least one uppercase letter.
- Password has at least special character.

Additional rules can be added through `di.xml` to the `rules` constructor parameter of the following class: `Vendic\AdminPasswordPolicy\Plugin\ValidatePassword`
Additional forbidden words can be added through `di.xml` to the `forbiddenWords` constructor parameter of the following class: `Vendic\AdminPasswordPolicy\Rules\DoesNotContain`

Users who have not logged in the past 90 days will automatically be set on inactive by a cron job that runs every midnight. It is possible to exclude users from being marked as inactive via configuration.

## Installation

```bash
composer require vendic/magento2-admin-password-policy
```

## Configuration

None at this moment. Feel free to create a pull request if you need specific settings. Check the [issues](https://github.com/Vendic/magento2-admin-password-policy/issues) for tickets that need help.

## Compatibility
- Magento 2 or [Mage-OS](https://mage-os.org/) ^2.4.4

## License
[MIT](https://github.com/Vendic/magento2-admin-password-policy/blob/main/LICENSE)

## Authors
- [Zaahed Yaqubi](https://vendic.nl/)
