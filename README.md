## Intro
This example shows in a very simple way how to handle filters through an HTTP request.

The first idea is to have a really simple API and call filters with just one method and no conditions.

**Instead of something very verbose like this (and likely going to spread to infinity).**
```$php
<?php
ThreadResource::collection(
    Thread::query()
        ->when($request->get('owner') !== null, static function($query) use($request){
            $query->where('owner_id', $request->get('owner'));
        })
        ->when($request->get('replied') !== null, static function($query) use($request){
            if($request->get('replied') == '1' || $request->get('replied') === 'true'){
                $query->where('replied', true);
            }

            if($request->get('replied') == '0' || $request->get('replied') === 'false'){
                $query->where('replied', false);
            }
        })
        ->when(/*... And so on, I think you got the idea... */)
        ->when($request->get('order') !== null, static funtion($query) use($request){
            $order = explode(',', $request->get('order'));
            $query->orderBy($order[0], $order[1] ?? 'ASC');
        })
        ->paginate()
```

**We have this which is much simpler and more readable**
```$php
ThreadResource::collection(
    Thread::query()
        ->filter($request)
        ->sort($request->get('order'))
        ->paginate()
);
```

---

#### A way to achieve this is done by: 
- Using a scope in a trait for filtering 
- Having an abstract class responsible of "filters" methods (resolve filters, add filters, ...)
- Having an abstract class responsible of "each filter" (mapping, filtering)

**When you need to filter an Eloquent model:**
 - Use the `Filterable` trait 
 - Set the `$filterableClass` (ex: `public $filterableClass = ThreadFilters::class;`)
 - Create the filterable class (ex `App/Models/Filters/Thread/ThreadFilters`)
 - In your controller, you can now call the `filter` method

- `App/Models/Filters/Thread/ThreadFilters` contains all available filters. The key in the array is the query param you can use in your URL. (ex: ?owner=1). The value is the filter's class for this query param.
- Create 1 class for each query param. You can reuse the logic by calling Eloquent scopes or using trait inside these class too.

The easiest way to play with is by looking at `App\Http\Controllers\ThreadController`, `App/Models/Thread` model, and Thread filters in `app/Models/Filters/Thread`

#### Advantages
- Clean controller
- Simple API
- Easily testable component
- Highly conventional filters
- DRY
- SRP

---

## Requirements
- php7.3
- composer
- Virtualbox
- Vagrant

---

## Install
### With Homestead (recommended)
- Install dependencies: `composer install`
- Edit your `Homestead.yaml` (example below)
- Run Homestead machine `vagrant up && vagrant ssh`
- `cd code`
- `php artisan key:generate`
- Edit the `.env` at your convenience (check `.env.example`)
- `php artisan migrate --seed`

---
### Homestead
```$yaml
ip: 192.168.10.10
memory: 2048
cpus: 2
provider: virtualbox
authorize: ~/.ssh/id_rsa.pub
keys:
    - ~/.ssh/id_rsa
folders:
    -
        map: /home/username/Documents/Prestashop/Workspace/addons-filters-example
        to: /home/vagrant/code
sites:
    -
        map: addons-filters-example.prestashop.local
        to: /home/vagrant/code/public
databases:
    - addons_filters_example_dev
    - addons_filters_example_test
features:
    -
        mariadb: false
    -
        ohmyzsh: true
    -
        webdriver: true
name: addons-filters-example.prestashop.local
hostname: addons-filters-example.prestashop.local
```
---

### TODO
- Docker compose
- Tests
- Example with different formats. (Ex date=xxx,yyy for a period, etc...)
