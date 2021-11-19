<?php

namespace App\Http\Controllers;

use App\Exceptions\CustomerNotFoundException;
use App\Http\Requests\CustomerCreateOrUpdateRequestValidate;
use App\Models\Customer;
use App\Services\CustomerService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Throwable;

class CustomerController extends Controller
{
    protected CustomerService $customerService;

    public function __construct()
    {
        $this->customerService = App::make(CustomerService::class);
    }

    public function getCustomers(): \Illuminate\Database\Eloquent\Collection|array
    {
        return $this->customerService->getAllCustomers();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     * @throws ValidationException
     */
    public function index()
    {
        try {
            $this->authorize('viewAny', Customer::class);

            return Inertia::render('Customers/List', [
                'customers' => $this->getCustomers(),
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
     * @throws ValidationException
     */
    public function create()
    {
        try {
            $this->authorize('create', Customer::class);

            return Inertia::render('Customers/CreateOrUpdate');
        }catch (Exception $exception){
            throw ValidationException::withMessages([
                'error' => $exception->getMessage(),
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CustomerCreateOrUpdateRequestValidate $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function store(CustomerCreateOrUpdateRequestValidate $request)
    {
        try {
            if($request->user()->cannot('create', Customer::class))
                abort(403);

            $this->customerService->createNewCustomer(Auth::id(), $request->name, $request->document, $request->status);

            return Redirect::route('customers.index')->with('success', 'Successfully registered customer.');
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
            $this->authorize('update', Customer::class);

            $customer = $this->customerService->findCustomerById($id);

            if(!$customer)
                throw new CustomerNotFoundException();

            return Inertia::render('Customers/CreateOrUpdate', ['customer' => $customer]);
        }catch (Exception $exception){
            throw ValidationException::withMessages([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CustomerCreateOrUpdateRequestValidate $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function update(CustomerCreateOrUpdateRequestValidate $request, $id)
    {
        try {
            if($request->user()->cannot('update', Customer::class))
                abort(403);

            $this->customerService->editCustomer($request->toArray(), $id);

            return Redirect::route('customers.index')->with('success', 'Successfully updated customer.');
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
            if($request->user()->cannot('update', Customer::class))
                abort(403);

            $this->customerService->editCustomer($request->toArray(), $id);

            return Redirect::route('customers.index')->with('success', 'Successfully updated customer.');
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
            $this->authorize('delete', Customer::class);

            $this->customerService->deleteCustomerById($id);

            //Redirect::route('customers.index', ['status' => 'success', 'msg' => 'Successfully deleted customer.']);
            return Redirect::route('customers.index')->with('success', 'Successfully deleted customer.');

        } catch (CustomerNotFoundException | Throwable $e) {
            throw ValidationException::withMessages([
                'error' => $e->getMessage(),
            ]);
        }
    }
}
