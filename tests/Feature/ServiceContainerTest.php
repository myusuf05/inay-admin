<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

// Depedency Injector
class ServiceContainerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    // Laravel mempunyai suatu fitur untuk mempermudah dalam penerapan depedency injection
    // Fitur itu dinamakan dengan Service Container
    public function test_basic_di() {
        // Misalnya contoh dibawah ini :
        $foo1 = $this->app->make(Foo::class); // $foo1 = new Foo();
        $foo2 = $this->app->make(Foo::class); // $foo2 = new Foo();

        self::assertEquals("Foo", $foo1);
        self::assertEquals("Foo", $foo2);

        // $foo1 dan $foo2 pasti memiliki object yang berbeda beda, 
        // karena default pemanggilan make akan selalu membuat project baru ketika didefinisikan
        self::assertNotSame($foo1, $foo2);
    }

    // Binding Parameter ke suatu object.
    public function test_binding() {
        // Set parameter ke class Foo, jika constructor Foo memiliki parameter
        $this->app->bind(Foo::class, function($app) {
            return new Foo("Ihwan", "Mualana");
        });

        $foo1 = $this->app->make(Foo::class); // $foo1 = new Foo("Ihwan", "Mualana");
        $foo2 = $this->app->make(Foo::class); // $foo2 = new Foo("Ihwan", "Mualana");


        self::assertEquals("Ihwan Mualana", $foo1->foo());
        self::assertEquals("Ihwan Mualana", $foo2->foo());

        // $foo1 dan $foo2 pasti memiliki object yang berbeda beda, 
        // karena default pemanggilan make akan selalu membuat project baru ketika didefinisikan
        self::assertNotSame($foo1, $foo2);
    }

    // Singleton hanya akan membuat object sekali saja, dan jika kita membuat
    // object baru dengan menggunakan fungsi make maka object yang sama yang akan
    // terpanggil
    public function test_singleton() {
        // Set parameter ke class Foo, jika constructor Foo memiliki parameter
        $this->app->singleton(Foo::class, function($app) {
            return new Foo("Ihwan", "Mualana");
        });

        $foo1 = $this->app->make(Foo::class); // $foo1 = new Foo("Ihwan", "Mualana");
        $foo2 = $this->app->make(Foo::class); // $foo2 = $foo1;


        self::assertEquals("Ihwan Mualana", $foo1->foo());
        self::assertEquals("Ihwan Mualana", $foo2->foo());

        // $foo1 dan $foo2 pasti memiliki object yang sama, karena singleton akan terus 
        // menggunakan object yang sama disetiap pemanggilan yang berbeda
        self::assertSame($foo1, $foo2);

    }

    // instance merupakan alternative dari singleton. Perbedaannya, instance 
    // tidak menggunakan clousure melainkan object yang sudah ada. 
    public function test_instance() {
        // Create Object
        $foo = new Foo("Ihwan", "Mualana");

        // Initialize Instance
        $this->app->instance(Foo::class, $foo);

        $foo1 = $this->app->make(Foo::class); // $foo1 = new Foo("Ihwan", "Mualana");
        $foo2 = $this->app->make(Foo::class); // $foo2 = $foo1;


        self::assertEquals("Ihwan Mualana", $foo1->foo());
        self::assertEquals("Ihwan Mualana", $foo2->foo());

        // $foo1 dan $foo2 pasti memiliki object yang sama, karena singleton akan terus 
        // menggunakan object yang sama disetiap pemanggilan yang berbeda
        self::assertSame($foo1, $foo2);

    }

    
    public function test_di_in_closure() {
        $this->app->singleton(Foo::class, function($app) {
            return new Foo();
        });

        $this->app->singleton(Bar::class, function($app) {
            // Memanggil object yang sama dengan diatas
            $foo = $this->app->make(Foo::class);
            return new Bar($foo);
        });

        $foo = $this->app->make(Foo::class);
        $bar1 = $this->app->make(Bar::class);
        $bar2 = $this->app->make(Bar::class);


        self::assertEquals("Ihwan Mualana", $foo1->foo());
        self::assertEquals("Ihwan Mualana", $foo2->foo());

        // $foo1 dan $foo2 pasti memiliki object yang sama, karena singleton akan terus 
        // menggunakan object yang sama disetiap pemanggilan yang berbeda
        self::assertSame($foo1, $foo2);
    }
}

/*
// Foo withouth Parameter
class Foo {
    public function __construct() {
        return "Foo";
    }
}

// Foo with Parameter
class Foo {
    public function __construct(
        public string $firstName,
        public string $lastName,
    ){
        return $firstName . " " . $lastName;
    }
}
*/