<?php

namespace App\Providers;

use App\Utils\Factory;
use League\Fractal\Manager;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\MessageBag;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;

/**
 * Class AppServiceProvider
 *
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootSingletons();
        $this->registerObjects();
        $this->bootContracts();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'prod') {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }

    /**
     * Register macro objects.
     */
    private function registerObjects()
    {
        /**
         * Macro for response
         */
        $this
            ->app
            ->make(ResponseFactory::class)
            ->macro('jsend', function (
                $data,
                string $message = '',
                int $code = 200,
                array $headers = [],
                string $status = 'success'
            ) {
                if ($message instanceof MessageBag) {
                    $message = $message->first();
                }

                if ($code >= 200 && $code < 300) {
                    $status = 'success';
                } elseif ($code >= 400 && $code < 500) {
                    $status = 'fail';
                } elseif ($code >= 500) {
                    $status = 'error';
                }

                return $this->json([
                    'status' => $status,
                    'message' => $message,
                    'data' => $data
                ], $code, $headers);
            });

        $this
            ->app
            ->make(ResponseFactory::class)
            ->macro('paginated', function (
                LengthAwarePaginator $data,
                string $message,
                array $headers = []
            ) {
                $data = $data->toArray();
                $headers = array_merge([
                    'X-PAGINATE-TOTAL' => $data['total'],
                    'X-PAGINATE-FROM' => $data['from'],
                    'X-PAGINATE-TO' => $data['to'],
                    'X-PAGINATE-LIMIT' => $data['per_page'],

                    'X-PAGINATE-LAST-PAGE' => $data['last_page'],
                    'X-PAGINATE-CURRENT-PAGE' => $data['current_page'],
                    'X-PAGINATE-PREVIOUS-PAGE-URL' => $data['prev_page_url'],
                    'X-PAGINATE-FIRST-PAGE-URL' => $data['first_page_url'],

                    'X-PAGINATE-LAST-PAGE-URL' => $data['last_page_url'],
                    'X-PAGINATE-NEXT-PAGE-URL' => $data['next_page_url'],
                ], $headers);

                $outPut['items'] = $data['data'];
                unset($data['data']);
                $outPut['meta'] = $data;

                return $this->jsend($outPut, $message, 200, $headers);
            });
    }

    /**
     * Boot Contracts.
     */
    private function bootContracts()
    {
        $this->app->bind('App\Contracts\JwtAuthContract', 'App\Utils\JWTAuthenticator');
    }

    /**
     * Boot all the application singletons
     */
    private function bootSingletons()
    {
        // Singleton for Fractal
        $this->app->singleton('League\Fractal\Manager', function () {
            return new Manager();
        });

        // Singleton for Resource factory
        $this->app->singleton('App\Utils\Factory', function () {
            return new Factory('League\\Fractal\\Resource');
        });
    }
}
