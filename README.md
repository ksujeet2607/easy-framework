# Easy

A lightweight PHP framework: DI-based routing (`nikic/fast-route` + `php-di`), an
HTTP layer (Request/Response/RedirectResponse), middleware pipeline, session
management, a template compiler/renderer with caching, a security layer
(guards, auth strategies, CSRF, password hashing), and a base controller
your application controllers extend.

This package intentionally contains **no application/business code** — no
entities, no domain services. It's the reusable core that an application
repo installs as a dependency.

## Install

```bash
composer require ksujeet2607/easy-framework
```

## Wiring it into your app

`Library\Http\Controllers\BaseController` depends on two small contracts
instead of any concrete class from your app, so your app supplies the
implementations:

```php
use Library\Contracts\Authenticatable;
use Library\Contracts\AppContextInterface;

class User extends YourOrmEntity implements Authenticatable {}

class AppContext implements AppContextInterface
{
    public function user(): ?Authenticatable { /* ... */ }
}
```

Then your app's own base controller just extends the framework one:

```php
namespace App\Controllers;

use Library\Http\Controllers\BaseController as FrameworkBaseController;

abstract class BaseController extends FrameworkBaseController
{
}
```

Every existing `SomeController extends BaseController` in your app keeps
working unchanged.

## What changed from the original in-app version

- Removed two dead imports (`App\Services\Supports\CompanyContext`,
  `App\Services\UserAccessService`) that referenced classes which no longer
  exist in the codebase — these were causing a class-not-found risk on
  autoload.
- `BaseController` now depends on `Library\Contracts\AppContextInterface` /
  `Authenticatable` instead of concrete `App\Services\Core\AppContext` /
  `App\Entities\Support\User`, so the framework has zero dependency on
  application code.
- Added `dompdf/dompdf`, `symfony/form`, `symfony/validator`,
  `symfony/security-csrf`, and `symfony/http-foundation` to `require` — these
  were used by framework code (`Library\Utilities\Utility`,
  `Library\Factory\FormFactory`) but were missing from `composer.json`.
- Removed `symfony/var-exporter` and `symfony/uid` — unused anywhere in
  `core/` or `library/`.

## License

MIT — see [LICENSE](LICENSE).
