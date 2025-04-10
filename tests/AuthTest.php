<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class AuthTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test de registro de usuario
     */
    public function testUserRegistration()
    {
        $this->post('/auth/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        $this->seeStatusCode(201);
        $this->seeJsonStructure([
            'status',
            'message',
            'user' => ['id', 'name', 'email', 'created_at', 'updated_at'],
            'token'
        ]);
    }

    /**
     * Test de inicio de sesión
     */
    public function testUserLogin()
    {
        // Primero creamos un usuario
        $this->post('/auth/register', [
            'name' => 'Login Test',
            'email' => 'login@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123'
        ]);

        // Intentamos iniciar sesión
        $this->post('/auth/login', [
            'email' => 'login@example.com',
            'password' => 'password123'
        ]);

        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'status',
            'message',
            'user' => ['id', 'name', 'email', 'created_at', 'updated_at'],
            'token'
        ]);
    }

    /**
     * Test de credenciales inválidas
     */
    public function testInvalidCredentials()
    {
        $this->post('/auth/login', [
            'email' => 'nobody@example.com',
            'password' => 'wrongpassword'
        ]);

        $this->seeStatusCode(401);
        $this->seeJsonContains([
            'status' => 'error',
            'message' => 'Credenciales inválidas'
        ]);
    }
}

class PlaceTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * Test de listado de lugares
     */
    public function testListPlaces()
    {
        $this->get('/places');

        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'status',
            'data' => [
                'current_page',
                'data' => [
                    '*' => [
                        'id', 'name', 'description', 'address', 'district', 'city', 'state',
                        'category' => ['id', 'name', 'description']
                    ]
                ],
                'first_page_url',
                'from',
                'last_page',
                'last_page_url',
                'links',
                'next_page_url',
                'path',
                'per_page',
                'prev_page_url',
                'to',
                'total'
            ]
        ]);
    }

    /**
     * Test de filtrado por alcaldía
     */
    public function testFilterByDistrict()
    {
        $this->get('/places/district/Cuauhtémoc');

        $this->seeStatusCode(200);
        $this->seeJsonStructure([
            'status',
            'data' => [
                '*' => [
                    'id', 'name', 'description', 'address', 'district'
                ]
            ]
        ]);
    }
}
