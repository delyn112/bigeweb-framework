<?php

namespace Bigeweb\Authentication\Repositories\Interfaces;

interface ProfileRepositoryInterface
{
    public function getUser(int $id = null, string $token = null);

    public function update($request, $id);

    public function updateVerifyEmail(?int $id, ?array $data);
}