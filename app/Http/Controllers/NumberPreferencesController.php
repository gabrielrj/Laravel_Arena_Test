<?php

namespace App\Http\Controllers;

use App\Exceptions\NumberPreferencesCreatedException;
use App\Exceptions\NumberPreferencesNotFoundException;
use App\Http\Requests\NumberPreferenceCreateOrUpdateRequestValidate;
use App\Models\NumberPreferences;
use App\Services\NumberPreferencesService;
use App\Services\NumberService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;
use Throwable;

class NumberPreferencesController extends Controller
{
    protected NumberPreferencesService $numberPreferencesService;
    protected NumberService $numberService;

    public function __construct()
    {
        $this->numberPreferencesService = App::make(NumberPreferencesService::class);
        $this->numberService = App::make(NumberService::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Inertia\Response
     * @throws ValidationException
     */
    public function index($id)
    {
        try {
            $this->authorize('viewAny', NumberPreferences::class);

            $number = $this->numberService->findNumberById($id);
            $customer = $number->customer;
            $preferences = $number->preferences;

            return Inertia::render('Numbers/Preferences/List', [
                'number' => $number,
                'customer' => $customer,
                'preferences' => $preferences,
            ]);
        }catch (\Exception $exception){
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
    public function create($id)
    {
        try {
            $this->authorize('create', NumberPreferences::class);

            $number = $this->numberService->findNumberById($id, ['customer']);

            return Inertia::render('Numbers/Preferences/CreateOrUpdate', ['number' => $number]);
        }catch (\Exception $exception){
            throw ValidationException::withMessages([
                'error' => $exception->getMessage(),
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param NumberPreferenceCreateOrUpdateRequestValidate $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function store(NumberPreferenceCreateOrUpdateRequestValidate $request)
    {
        try {
            if($request->user()->cannot('create', NumberPreferences::class))
                abort(403);

            $this->numberPreferencesService->addNumberPreference($request->number_id, $request->name, $request->value);

            return Redirect::route('preferences.index', [$request->number_id])->with('success', 'Successfully registered preference.');
        }catch (Exception | NumberPreferencesCreatedException $e){
            throw ValidationException::withMessages([
                'error' => $e->getMessage(),
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
            $this->authorize('update', NumberPreferences::class);

            $preference = $this->numberPreferencesService->findPreferenceById($id);
            $number = $this->numberService->findNumberById($preference->number_id, ['customer']);

            if(!$preference)
                throw new NumberPreferencesNotFoundException();

            return Inertia::render('Numbers/Preferences/CreateOrUpdate', ['number' => $number, 'preference' => $preference ]);
        }catch (Exception $exception){
            throw ValidationException::withMessages([
                'error' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws ValidationException
     */
    public function update(Request $request, $id)
    {
        try {
            if($request->user()->cannot('update', NumberPreferences::class))
                abort(403);

            $this->numberPreferencesService->editNumberPreference($request->toArray(), $id);

            return Redirect::route('preferences.index', [$request->number_id])->with('success', 'Successfully updated preference.');
        }catch (Exception | \Throwable $e){
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
     * @throws ValidationException|Throwable
     */
    public function destroy($id)
    {
        try {
            $this->authorize('delete', NumberPreferences::class);

            $numberId = $this->numberPreferencesService->findPreferenceById($id)->number_id;

            $this->numberPreferencesService->deleteNumberPreferenceById($id);

            //Redirect::route('numbers.index', ['status' => 'success', 'msg' => 'Successfully deleted number.']);
            return Redirect::route('preferences.index', [$numberId])->with('success', 'Successfully deleted preference.');

        } catch (Exception $e) {
            throw ValidationException::withMessages([
                'error' => $e->getMessage(),
            ]);
        }
    }
}
