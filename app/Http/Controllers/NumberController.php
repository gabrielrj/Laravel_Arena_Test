<?php

namespace App\Http\Controllers;

use App\Exceptions\NumberNotFoundException;
use App\Http\Requests\NumberCreateOrUpdateRequestValidate;
use App\Models\Number;
use App\Services\CustomerService;
use App\Services\NumberService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Throwable;

class NumberController extends Controller
{
    protected NumberService $numberService;
    protected CustomerService $customerService;

    public function __construct()
    {
        $this->numberService = App::make(NumberService::class);
        $this->customerService = App::make(CustomerService::class);
    }

    public function getNumbers(int $id, array $relationships = []): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->numberService->getAllNumbersByCustomerId($id, $relationships);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws ValidationException
     */
    public function index()
    {
        try {
            $this->authorize('viewAny', Number::class);

            $customers = $this->customerService->getAllCustomers(['numbers.preferences']);

            return Inertia::render('Numbers/List', [
                'customers' => $customers,
            ]);
        }catch (Exception $exception){
            throw ValidationException::withMessages([
                'error' => $exception->getMessage(),
            ]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Inertia\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws ValidationException
     */
    public function create($id)
    {
        try {
            $this->authorize('create', Number::class);

            $customer = $this->customerService->findCustomerById($id);

            return Inertia::render('Numbers/CreateOrUpdate', ['customer' => $customer]);
        }catch (Exception $exception){
            throw ValidationException::withMessages([
                'error' => $exception->getMessage(),
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NumberCreateOrUpdateRequestValidate $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function store(NumberCreateOrUpdateRequestValidate $request)
    {
        try {
            if($request->user()->cannot('create', Number::class))
                abort(403);

            $this->numberService->addNumber($request->customer_id, $request->number, $request->status);

            return Redirect::route('numbers.index')->with('success', 'Successfully registered number.');
        }catch (Exception $exception){
            throw ValidationException::withMessages([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Inertia\Response
     * @throws ValidationException
     */
    public function edit($id)
    {
        try {
            $this->authorize('update', Number::class);

            $number = $this->numberService->findNumberById($id);

            if(!$number)
                throw new NumberNotFoundException();

            return Inertia::render('Numbers/CreateOrUpdate', ['number' => $number, 'customer' => $number->customer]);
        }catch (Exception $exception){
            throw ValidationException::withMessages([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param NumberCreateOrUpdateRequestValidate $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function update(NumberCreateOrUpdateRequestValidate $request, $id)
    {
        try {
            if($request->user()->cannot('update', Number::class))
                abort(403);

            $this->numberService->editNumber($request->toArray(), $id);

            return Redirect::route('numbers.index')->with('success', 'Successfully updated number.');
        }catch (Exception | Throwable $e){
            throw ValidationException::withMessages([
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @throws ValidationException
     */
    public function changeStatus(Request $request, $id)
    {
        try {
            if($request->user()->cannot('update', Number::class))
                abort(403);

            $this->numberService->editNumber($request->toArray(), $id);

            return Redirect::route('numbers.index')->with('success', 'Successfully updated number.');
        }catch (Exception | Throwable $e){
            throw ValidationException::withMessages([
                'error' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function destroy($id)
    {
        try {
            $this->authorize('delete', Number::class);

            $this->numberService->deleteNumberById($id);

            //Redirect::route('numbers.index', ['status' => 'success', 'msg' => 'Successfully deleted number.']);
            return Redirect::route('numbers.index')->with('success', 'Successfully deleted number.');

        } catch (NumberNotFoundException | Throwable $e) {
            throw ValidationException::withMessages([
                'error' => $e->getMessage(),
            ]);
        }
    }
}
