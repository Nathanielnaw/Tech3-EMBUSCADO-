<?php

namespace App\Controllers;

use App\Models\CustomerModel;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Exceptions\PageNotFoundException;

class Customers extends BaseController
{
    public function index(): string
    {
        $customers = (new CustomerModel())->orderBy('id', 'ASC')->findAll();

        return view('customers/index', ['customers' => $customers]);
    }

    public function create(): string
    {
        return $this->formView(['full_name' => '', 'email' => '', 'phone' => '']);
    }

    public function store(): RedirectResponse|string
    {
        $values = $this->inputValues();

        if (! $this->validateData($values, $this->rules())) {
            $this->response->setStatusCode(422);

            return $this->formView($values, $this->validator->getErrors());
        }

        $model = new CustomerModel();
        $model->insert([
            'full_name'  => $values['full_name'],
            'email'      => $values['email'],
            'phone'      => $values['phone'] === '' ? null : $values['phone'],
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(url_to('customers'));
    }

    public function edit(int $id): string
    {
        return $this->formView($this->findCustomer($id), [], $id);
    }

    public function update(int $id): RedirectResponse|string
    {
        $this->findCustomer($id);
        $values = $this->inputValues();

        if (! $this->validateData($values, $this->rules())) {
            $this->response->setStatusCode(422);

            return $this->formView($values, $this->validator->getErrors(), $id);
        }

        (new CustomerModel())->update($id, [
            'full_name' => $values['full_name'],
            'email'     => $values['email'],
            'phone'     => $values['phone'] === '' ? null : $values['phone'],
        ]);

        return redirect()->to(url_to('customers'));
    }

    private function inputValues(): array
    {
        return [
            'full_name' => $this->postString('full_name'),
            'email'     => $this->postString('email'),
            'phone'     => $this->postString('phone'),
        ];
    }

    private function rules(): array
    {
        return [
            'full_name' => ['label' => 'Full name', 'rules' => 'required|max_length[100]'],
            'email'     => ['label' => 'Email', 'rules' => 'required|valid_email|max_length[100]'],
            'phone'     => ['label' => 'Phone', 'rules' => 'permit_empty|max_length[20]'],
        ];
    }

    private function findCustomer(int $id): array
    {
        $customer = $id > 0 ? (new CustomerModel())->find($id) : null;

        if (! is_array($customer)) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $customer;
    }

    private function formView(array $values, array $errors = [], ?int $id = null): string
    {
        return view('customers/form', [
            'heading' => $id === null ? 'New Customer' : 'Edit Customer',
            'action'  => $id === null ? url_to('customers.store') : url_to('customers.update', $id),
            'values'  => $values,
            'errors'  => $errors,
        ]);
    }
}
