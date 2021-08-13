<?php

namespace lumilock\lumilockGateway\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use lumilock\lumilockGateway\App\Services\RouteService;
use lumilock\lumilockGateway\App\Traits\ApiResponser;

class GatewayController extends Controller
{
    use ApiResponser;

    /**
     * The service to consume the authors micro-service
     * @var RouteService
     */
    public $routeService;

    public function __construct(RouteService $routeService)
    {
        $this->routeService = $routeService;
    }

    private function authRequest(String $methode, String $path, $data, $auth)
    {
        // create auth service infos
        $service = (object)["uri" => env("AUTH_URI"), "secret" => env("SSO_SECRET")];
        $this->routeService->setUri($service->uri);
        $this->routeService->setSecret(''); // no secret because of 'Authorization_sso_secret'
        // Auth need auth bearer
        $headers['Authorization'] = $auth;
        // Auth have a specifique Authorization header
        $headers['Authorization_sso_secret'] = $service->secret;
        $response = (Object) $this->routeService->route($methode, $path, $data, $headers);
        return $this->successResponse($response->content, $response->status);
    }

    /**
     * routesGet.
     *
     */
    public function routesGet(Request $request)
    {
        // we create a list of slug
        $slug_array = preg_split("/\//", $request->path());
        // we check that we have 2 slug (api / <serviceName>)
        if (count($slug_array) >= 2 && strcmp($slug_array[0], "api") === 0) {
            try {
                // we check if it's a Auth request 
                if (strcmp($slug_array[1], "auth") === 0) {
                    return $this->authRequest($request->method(), $request->getRequestUri(), [], $request->header('Authorization'));
                } else {
                    $path = '/' . $slug_array[0] . '/' . $slug_array[1]; // we re-create the service path in order to find the uri
                    // we get the service from the Auth micro-service lumen app
                    $service_response = (Object) $this->routeService->route('POST', env("AUTH_URI") . '/api/auth/services/getByPath', ["path" => $path], ['Authorization' => $request->header('Authorization'), 'Authorization_sso_secret' => env('SSO_SECRET')]);
                    $service_content = json_decode($service_response->content);
                    if (!$service_content) {
                        throw new Exception("Error Processing Request", 1);
                    }
                    $service = $service_content->data;
                    $this->routeService->setUri($service->uri);
                    $this->routeService->setSecret($service->secret);
                    $headers['Authorization'] = $request->header('Authorization');
                    $response = (Object) $this->routeService->route($request->method(), $request->getRequestUri(), [], $headers);
                    return $this->successResponse($response->content, $response->status);
                }
                throw new Exception("Error Processing Request", 1);
            } catch (\Exception $e) {
                return response()->json(
                    [
                        'data' => null,
                        'status' => 'NOT_FOUND',
                        'message' => 'Service not found!'
                    ],
                    404
                );
            }
        }
    }

    /**
     * routesPost.
     *
     */
    public function routesPost(Request $request)
    {
        // we create a list of slug
        $slug_array = preg_split("/\//", $request->path());
        // we check that we have 2 slug (api / <serviceName>)
        if (count($slug_array) >= 2 && strcmp($slug_array[0], "api") === 0) {
            //AUTH_URI
            try {
                $path = '/' . $slug_array[0] . '/' . $slug_array[1]; // we re-create the service path in order to find the uri
                // we check if it's a Auth request 
                if (strcmp($slug_array[1], "auth") === 0) {
                    return $this->authRequest($request->method(), $request->getRequestUri(), $request->all(), $request->header('Authorization'));
                } else {
                    // we get the service from the Auth micro-service lumen app
                    $service_response = (Object) $this->routeService->route('POST', env("AUTH_URI") . '/api/auth/services/getByPath', ["path" => $path], ['Authorization' => $request->header('Authorization'), 'Authorization_sso_secret' => env('SSO_SECRET')]);
                    $service_content = json_decode($service_response->content);
                    if (!$service_content) {
                        throw new Exception("Error Processing Request", 1);
                    }
                    $service = $service_content->data;
                    $this->routeService->setUri($service->uri);
                    $this->routeService->setSecret($service->secret);
                    $headers['Authorization'] = $request->header('Authorization');
                    $response = (Object) $this->routeService->route($request->method(), $request->getRequestUri(), $request->all(), $headers);
                    return $this->successResponse($response->content, $response->status);
                }
                throw new Exception("Error Processing Request", 1);
            } catch (\Exception $e) {
                return response()->json(
                    [
                        'data' => null,
                        'status' => 'NOT_FOUND',
                        'message' => 'Service not found!'
                    ],
                    404
                );
            }
        }
        // dd($request->path(), $request->method(), $request->getHttpHost(), $request->all());
    }
}
