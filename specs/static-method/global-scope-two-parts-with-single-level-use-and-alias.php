<?php

declare(strict_types=1);

/*
 * This file is part of the humbug/php-scoper package.
 *
 * Copyright (c) 2017 Théo FIDRY <theo.fidry@gmail.com>,
 *                    Pádraic Brady <padraic.brady@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

return [
    'meta' => [
        'title' => 'Static method call statement of a namespaced class imported with an aliased use statement in the global scope',
        // Default values. If not specified will be the one used
        'prefix' => 'Humbug',
        'whitelist' => [],
    ],

    [
        'spec' => <<<'SPEC'
Static method call statement of a namespaced class partially imported with an aliased use statement:
- do not touch the use statement: see tests for the use statements as to why
- prefix the call
- transform the call into a FQ call
SPEC
        ,
        'payload' => <<<'PHP'
<?php

use Foo as A;

A\Bar::main();
----
<?php

use Foo as A;
\Humbug\Foo\Bar::main();

PHP
    ],

    [
        'spec' => <<<'SPEC'
Static method call statement of a namespaced class imported with an aliased use statement:
- prefix the use statement
- prefix the call
- transform the call into a FQ call
SPEC
        ,
        'payload' => <<<'PHP'
<?php

use Foo\Bar as A;

A::main();
----
<?php

use Humbug\Foo\Bar as A;
\Humbug\Foo\Bar::main();

PHP
    ],

    [
        'spec' => <<<'SPEC'
FQ static method call statement of a namespaced class partially imported with an aliased use statement:
- do not touch the use statement: see tests for the use statements and classes of the global namespace as to why
- prefix the call
SPEC
        ,
        'payload' => <<<'PHP'
<?php

use Foo as A;

\A\Bar::main();
----
<?php

use Foo as A;
\Humbug\A\Bar::main();

PHP
    ],

    [
        'spec' => <<<'SPEC'
FQ static method call statement of a namespaced class imported with an aliased use statement:
- prefix the use statement
- do not touch the call: see tests for the use statements and classes of the global namespace as to why
SPEC
        ,
        'payload' => <<<'PHP'
<?php

use Foo\Bar as A;

\A::main();
----
<?php

use Humbug\Foo\Bar as A;
\A::main();

PHP
    ],

    [
        'spec' => <<<'SPEC'
Static method call statement of a whitelisted namespaced class partially imported with an aliased use statement:
- do not touch the use statement: see tests for the use statements as to why
- do not prefix the call
- transform the call into a FQ call
SPEC
        ,
        'whitelist' => ['Foo\Bar'],
        'payload' => <<<'PHP'
<?php

use Foo as A;

A\Bar::main();
----
<?php

use Foo as A;
\Foo\Bar::main();

PHP
    ],

    [
        'spec' => <<<'SPEC'
Static method call statement of a whitelisted namespaced class imported with an aliased use statement:
- prefix the use statement
- do not prefix the call
- transform the call into a FQ call
SPEC
        ,
        'whitelist' => ['Foo\Bar'],
        'payload' => <<<'PHP'
<?php

use Foo\Bar as A;

A::main();
----
<?php

use Foo\Bar as A;
\Foo\Bar::main();

PHP
    ],

    [
        'spec' => <<<'SPEC'
FQ static method call statement of a whitelisted namespaced class partially imported with an aliased use statement:
- do not touch the use statement: see tests for the use statements as to why
- prefix the call: as the call is FQ the use statement is ignored
SPEC
        ,
        'whitelist' => ['Foo\Bar'],
        'payload' => <<<'PHP'
<?php

use Foo as A;

\A\Bar::main();
----
<?php

use Foo as A;
\Humbug\A\Bar::main();

PHP
    ],

    [
        'spec' => <<<'SPEC'
FQ static method call statement of a whitelisted namespaced class imported with an aliased use statement:
- prefix the use statement
- do not prefix the call
- transform the call into a FQ call
SPEC
        ,
        'whitelist' => ['Foo\Bar'],
        'payload' => <<<'PHP'
<?php

use Foo\Bar as A;

\A::main();
----
<?php

use Foo\Bar as A;
\A::main();

PHP
    ],
];
