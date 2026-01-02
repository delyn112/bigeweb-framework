<?php

namespace Bigeweb\Authentication\Repositories\Interfaces;

interface LoginRepositoryInterface
{
    public function getById(int $id);
    public function getByEmail(?string $email);

    public function process_login($request);

    public function logout();
    public function customUpdate(int $id, array $data);
}