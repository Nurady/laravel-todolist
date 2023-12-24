<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $response = $this->get('/login');

        $response->assertSeeText('Login');
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            'user' => 'adis'
        ])->get('/login')->assertRedirect('/');
    }

    public function testLoginSuccess()
    {
        $this->post('/login', [
            'user' => 'adis',
            'password' => 'rahasia'
        ])->assertRedirect('/')->assertSessionHas('user', 'adis');
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            'user' => 'adis'
        ])->post('/login', [
            'user' => 'adis',
            'password' => 'rahasia'
        ])->assertRedirect('/');
    }

    public function testLoginValidationError()
    {
        $this->post('/login', [])->assertSeeText('User or Password is Required');
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            'user' => 'wrong',
            'password' => 'wrong'
        ])->assertSeeText('User or Password is Wrong');
    }

    public function testLogout()
    {
        $this->withSession([
            'user' => 'adis'
        ])->post('/logout')->assertRedirect('/')->assertSessionMissing('user');
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')->assertRedirect('/');
    }
}
