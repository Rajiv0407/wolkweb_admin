<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponser{

    protected function successResponse($data, $message = null, $code = 200)
	{//$response->header('Content-Type', 'image/svg+xml');
	//->header('Content-Type', 'image/svg+xml')
		return response()->json([
			'status'=>1, 
			'message' => $message, 
			'data' => $data
		], $code);
	}

	protected function errorResponse($message = null, $code)
	{
		
		return response()->json([
			'status'=>0,
			'message' => $message,
			'data' => (object)array()
		], $code);
	}

}