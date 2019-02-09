<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SessionController extends AbstractController
{
    /**
     * @Route("/session", name="session")
     */
    public function index()
    {
        session_start();

        return $this->render('session/index.html.twig', [
            'session_id' => session_id(),
        ]);
    }

    /**
     * @Route("/session/start", name="session_start", methods={"POST"})
     *
     */
    public function start()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST'
            && array_key_exists('id', $_POST)
        ) {
            session_id($_POST[id]);
            session_start();
        }

        return $this->redirectToRoute('session');
    }

    /**
     * @Route("/session/destroy", name="session_destroy")
     */
    public function destroy()
    {
        session_start();

        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Finalmente, destruir la sesión.
        session_destroy();

        return $this->redirectToRoute('session');
    }

    /**
     * @Route("/session/buy", name="session_buy")
     */
    public function buy()
    {
        session_start();

        if ($_SERVER['REQUEST_METHOD'] === 'POST'
            && array_key_exists('name', $_POST)
            && !empty($_POST['name'])
        ) {
            $_SESSION['products'][] = $_POST['name'];
        }

        return $this->render('session/buy.html.twig', [
            'session_id' => session_id(),
            'products' => $_SESSION['products'] ?? [],
        ]);
    }

    /**
     * @Route("/session/safe-buy", name="session_safe_buy")
     */
    public function safeBuy()
    {
        session_start();
        $error = false;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!array_key_exists('token', $_POST)
                || !array_key_exists('token', $_SESSION)
                || !hash_equals(
                    $_POST['token'],
                    $_SESSION['token']
                )
            ) {
                $error = 'Token erróneo';
            }

            if (array_key_exists('name', $_POST)
                && !empty($_POST['name'])
                && false === $error
            ) {
                $product = $_POST['name'];
                $_SESSION['products'][] = $product;
            }
        }

        $_SESSION['token'] =  bin2hex(random_bytes(32));

        return $this->render('session/safe_buy.html.twig', [
            'session_id' => session_id(),
            'error' => $error,
            'token' => $_SESSION['token'],
            'products' => $_SESSION['products'] ?? [],
        ]);

    }
}
