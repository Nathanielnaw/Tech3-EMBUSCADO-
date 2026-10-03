<?php

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\HTTP\Files\UploadedFile;
use CodeIgniter\HTTP\RedirectResponse;

class Users extends BaseController
{
    public function index(): string
    {
        $users = (new UserModel())->orderBy('id', 'ASC')->findAll();

        return view('users/index', ['users' => $users]);
    }

    public function create(): string
    {
        return $this->formView(['username' => '', 'full_name' => '']);
    }

    public function store(): RedirectResponse|string
    {
        $values = $this->inputValues();

        if (! $this->validateData($values, $this->rules())) {
            $this->response->setStatusCode(422);

            return $this->formView($values, $this->validator->getErrors());
        }

        (new UserModel())->insert([
            'username'   => $values['username'],
            'full_name'  => $values['full_name'],
            'created_at' => date('Y-m-d H:i:s'),
        ]);

        return redirect()->to(url_to('users'));
    }

    public function edit(int $id): string
    {
        $user = $this->findUser($id);

        return $this->formView($user, [], $id, $user);
    }

    public function update(int $id): RedirectResponse|string
    {
        $user = $this->findUser($id);
        $values = $this->inputValues();
        $errors = [];

        if (! $this->validateData($values, $this->rules($id))) {
            $errors = $this->validator->getErrors();
        }

        $file = $this->request->getFile('avatar');
        $hasUpload = $file !== null && $file->getError() !== UPLOAD_ERR_NO_FILE;
        $imageType = null;

        if ($hasUpload) {
            if (! $file->isValid()) {
                $errors['avatar'] = 'Avatar upload failed. Choose a JPG or PNG file no larger than 2 MB.';
            } elseif (! $this->validateData([], [
                'avatar' => 'uploaded[avatar]|max_size[avatar,2048]|is_image[avatar]|mime_in[avatar,image/jpeg,image/png]',
            ])) {
                $errors['avatar'] = 'Avatar must be a JPG or PNG image no larger than 2 MB.';
            } else {
                $details = @getimagesize($file->getTempName());
                $actualSize = filesize($file->getTempName());

                if ($details === false
                    || ! in_array($details[2], [IMAGETYPE_JPEG, IMAGETYPE_PNG], true)
                    || $actualSize === false
                    || $actualSize > 2 * 1024 * 1024) {
                    $errors['avatar'] = 'Avatar must contain a valid JPG or PNG image no larger than 2 MB.';
                } else {
                    $imageType = $details[2];
                }
            }
        }

        if ($errors !== []) {
            $this->response->setStatusCode(422);

            return $this->formView($values, $errors, $id, $user);
        }

        $data = ['username' => $values['username'], 'full_name' => $values['full_name']];
        $newAvatar = null;

        if ($hasUpload) {
            $newAvatar = $this->prepareAvatar($file, $imageType);

            if ($newAvatar === null) {
                $this->response->setStatusCode(422);

                return $this->formView($values, [
                    'avatar' => 'Could not prepare the avatar. Check that PHP GD is enabled and try another JPG or PNG.',
                ], $id, $user);
            }

            $data['avatar'] = $newAvatar;
        }

        try {
            $saved = (new UserModel())->update($id, $data);
        } catch (\Throwable $exception) {
            if ($newAvatar !== null) {
                $this->removeAvatar($newAvatar);
            }

            throw $exception;
        }

        if (! $saved) {
            if ($newAvatar !== null) {
                $this->removeAvatar($newAvatar);
            }

            $this->response->setStatusCode(500);

            return $this->formView($values, ['form' => 'Could not save the user. Please try again.'], $id, $user);
        }

        if ($newAvatar !== null && $user['avatar'] !== null && $user['avatar'] !== $newAvatar) {
            $this->removeAvatar($user['avatar']);
        }

        return redirect()->to(url_to('users'));
    }

    private function inputValues(): array
    {
        return [
            'username'  => $this->postString('username'),
            'full_name' => $this->postString('full_name'),
        ];
    }

    private function rules(?int $id = null): array
    {
        $unique = $id === null ? 'is_unique[users.username]' : 'is_unique[users.username,id,' . $id . ']';

        return [
            'username'  => ['label' => 'Username', 'rules' => 'required|max_length[50]|' . $unique],
            'full_name' => ['label' => 'Full name', 'rules' => 'required|max_length[100]'],
        ];
    }

    private function findUser(int $id): array
    {
        $user = $id > 0 ? (new UserModel())->find($id) : null;

        if (! is_array($user)) {
            throw PageNotFoundException::forPageNotFound();
        }

        return $user;
    }

    private function formView(array $values, array $errors = [], ?int $id = null, ?array $user = null): string
    {
        return view('users/form', [
            'heading' => $id === null ? 'New User' : 'Edit User',
            'action'  => $id === null ? url_to('users.store') : url_to('users.update', $id),
            'values'  => $values,
            'errors'  => $errors,
            'user'    => $user,
        ]);
    }

    private function prepareAvatar(UploadedFile $file, int $imageType): ?string
    {
        $folder = FCPATH . 'uploads/avatars/';

        if (! extension_loaded('gd') || ! is_dir($folder) || ! is_writable($folder)) {
            return null;
        }

        $extension = $imageType === IMAGETYPE_PNG ? '.png' : '.jpg';

        do {
            $filename = bin2hex(random_bytes(16)) . $extension;
            $target = $folder . $filename;
        } while (file_exists($target));

        try {
            service('image')->withFile($file->getTempName())->fit(160, 160)->save($target, 85);

            return $filename;
        } catch (\Throwable $exception) {
            if (is_file($target)) {
                @unlink($target);
            }

            log_message('error', 'Avatar processing failed: {message}', ['message' => $exception->getMessage()]);

            return null;
        }
    }

    private function removeAvatar(string $filename): void
    {
        if (! avatar_filename_is_safe($filename)) {
            return;
        }

        $path = FCPATH . 'uploads/avatars/' . $filename;

        if (is_file($path)) {
            @unlink($path);
        }
    }
}
