<?php namespace App\Http\Requests;

use App\Http\Requests\Request;
use Response;

class CreateEndFormRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			   'name' => 'required',
			   'location_id' => 'required'
	    ];
	}

	public function response(array $error)
    {
        return Response::json($error,400);

    }

}
