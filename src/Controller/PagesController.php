<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Pages Controller
 *
 * Renders static pages from templates/Pages/.
 * The root route redirects straight to the Dashboard for authenticated users.
 */
class PagesController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // home / display are publicly accessible (login page handles auth redirect)
        $this->Authentication->allowUnauthenticated(['display', 'home']);
    }

    /**
     * Displays a static page.
     *
     * @param string ...$path Path segments (e.g. 'home', 'about').
     *                        Defaults to 'home' when called with no args.
     * @return \Cake\Http\Response|null
     */
    public function display(string ...$path): ?\Cake\Http\Response
    {
        // No path → show home (or redirect authenticated users to dashboard)
        if (!$path) {
            $result = $this->Authentication->getResult();
            if ($result && $result->isValid()) {
                return $this->redirect(['controller' => 'Dashboard', 'action' => 'index']);
            }
            return $this->redirect(['controller' => 'Users', 'action' => 'login']);
        }

        // Block directory traversal
        if (in_array('..', $path, true) || in_array('.', $path, true)) {
            throw new \Cake\Http\Exception\ForbiddenException();
        }

        $page = implode('/', $path);

        $this->set(compact('page'));
        $this->viewBuilder()->setTemplate($page);

        return null;
    }
}
