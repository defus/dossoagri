<?php 

use \Closure;
use Illuminate\Support\Facades\Facade;

class SecurityCheck
{
    public $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function hasRole($permission)
    {
        if ($user = $this->user()) {
            return $user->hasRole($permission);
        }

        return false;
    }

    public function user()
    {
        return $this->app->auth->user();
    }

    /**
     * Filters a route for the name Role.
     *
     * If the third parameter is null then return 403.
     * Overwise the $result is returned.
     *
     * @param string       $route      Route pattern. i.e: "admin/*"
     * @param array|string $roles      The role(s) needed.
     * @param mixed        $result     i.e: Redirect::to('/')
     * @param bool         $cumulative Must have all roles.
     *
     * @return mixed
     */
    public function routeNeedsRole($route, $roles, $result = null, $cumulative=true)
    {
        if (!is_array($roles)) {
            $roles = array($roles);
        }

        $filter_name = implode('_',$roles).'_'.substr(md5($route),0,6);

        if (!$result instanceof Closure) {
            $result = function () use ($roles, $result, $cumulative) {
                $hasARole = array();
                foreach ($roles as $role) {
                    if ($this->hasRole($role)) {
                        $hasARole[] = true;
                    } else {
                        $hasARole[] = false;
                    }
                }

                // Check to see if it is false and then
                // check additive flag and that the array only contains false.
                if (in_array(false, $hasARole) && ($cumulative || count(array_unique($hasARole)) == 1) ) {
                    if(! $result)
                        Facade::getFacadeApplication()->abort(403, "Vous n'avez pas le droit d'accéder à cette page sur le serveur");

                    return $result;
                }
            };
        }

        // Same as Route::filter, registers a new filter
        $this->app->router->filter($filter_name, $result);

        // Same as Route::when, assigns a route pattern to the
        // previously created filter.
        $this->app->router->when( $route, $filter_name );
    }

    
}
