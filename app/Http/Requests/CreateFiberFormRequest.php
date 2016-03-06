<?php namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateFiberFormRequest extends Request {

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
		  $rules = [
		             'name' => 'required',
		             'brand' => 'required',
		             'cores' => 'required|numeric'

		           ];

		  foreach($this->request->get('fiber_cores') as $key => $val)
		  {
		       $rules['fiber_cores.'.$key] = 'required';
		  }

          
          return $rules;
	}

	public function response(array $error)
    {
        return \Response::json($error,400);

    }

}
