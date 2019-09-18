# Larvel query filter

Laravel query filter helps to filtering results on search. You don`t need to write if statement or eloquent builder method when in your search in order to filter your results.

# Installation
You can install the package via composer:
```sh
composer require jasco-b/query-filter
```

# Usage
You can write your filters in following ways:
  - Method
  - Stand alone class 
  - Closure

# Method
```php
use JascoB\QueryFilter\QueryFilter;

class PostFilter extends QueryFilter
{
    protected $filterableFields = ['title'];

    public function title($query, $value)
    {
        $query->orWhere('title', 'like', '%' . $value . '%');
    }

}
```

# Stand Alone Class

First of all we need to create a stand alone class which implements IFilterColumn or extends abstract class FilterColumn

```php
use JascoB\QueryFilter\Classes\FilterColumn;

class TagFilterColumn extends FilterColumn
{
    public function apply($value)
    {
        return $this->builder->whereHas('tags', function ($query) use ($value) {
            $query->where('name', 'like', '%' . $value . '%');
        });
    }
}
```

```php
use JascoB\QueryFilter\QueryFilter;

class PostFilter extends QueryFilter
{
    protected $filterableFields = ['title', 'tag'=>TagFilterColumn::class];
    
}
```

# Closure

```php
class PostFilter extends QueryFilter
{
    protected $filterableFields = [];

    public function __construct(Builder $builder)
    {
        parent::__construct($builder);
        $this->initFilters();
    }

    public function initFilters()
    {
        $this->filterableFields['title'] = function ($query, $value) {
            $query->where('title', 'like', "%$value%");
        };
    }
}
```

## Model
In your model you must use it.
```php
class Post extends Model
{
    public function scopeFilter($query, $request)
    {
        return (new PostFilter($query))->filter($request);
    }
```

## Controller 
In your controller, service or repository you can use it like this.
```php
class SearchController extends Controller
{
    public function filter(Request $request)
    {
       $posts =  Post::query()->filter($request->toArray())->get();
    }
}
```
