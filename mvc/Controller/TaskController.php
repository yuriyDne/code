<?php

namespace Controller;

use config\Constants;
use lib\Request;
use lib\View;
use mvc\Dto\Html\PagerDto;
use mvc\Dto\SortOrder;
use mvc\Dto\View\TaskViewDto;
use mvc\Enum\Repository\SortDirection;
use mvc\Enum\Repository\TaskField;

use mvc\Dto\TaskDto;
use mvc\Dto\Validator\RuleEmail;
use mvc\Dto\Validator\RuleNotEmptyString;
use mvc\Enum\TaskStatus;
use Service\ClientScript;
use Service\ServiceProvider;
use Service\Validator;

class TaskController extends AbstractSiteController
{
    /**
     * TaskController constructor.
     * @param ServiceProvider $serviceProvider
     * @param View $view
     * @param Request $request
     * @param Validator $validator
     * @param ClientScript $clientScript
     * @param string $actionName
     */
    public function __construct(
        ServiceProvider $serviceProvider,
        View $view,
        Request $request,
        Validator $validator,
        ClientScript $clientScript,
        string $actionName
    ) {
        parent::__construct($serviceProvider, $view, $request, $validator, $clientScript, $actionName);
        $this->clientScript->registerJsFile('TaskView');
        $this->clientScript->registerJsFile('Popup');

    }


    public function list()
    {
        $page = (int) $this->getRequest()->get('page', 1);
        $order = $this->getRequest()->get('order', null);
        if (!is_null($order)) {
            $parts = explode('|', $order);
            $order = new SortOrder(
                new TaskField($parts[0]),
                new SortDirection($parts[1])
            );
        } else {
            $order = new SortOrder(
                TaskField::ID(),
                SortDirection::DESC()
            );
        }

        $taskRepository = $this->serviceProvider->getRepositoryManager()->getTaskRepository();
        $dataProvider = $taskRepository->getDataProvider($page, Constants::TASK_PER_PAGE, $order);
        $pagerBaseUrl = $this->request->getUrlWithoutParams(
            $this->request->getRequestUri(),
            ['page']
        );

        $taskView = new TaskViewDto(
            $order,
            new PagerDto(
                $dataProvider,
                $pagerBaseUrl
            ),
            '/task/list'
        );

        $this->clientScript->registerJsFile('taskList');
        $this->view->withParam('taskView', $taskView)
            ->withParam('dataProvider', $dataProvider)
            ->render('task/list');
    }

    /**
     * @param null $id
     */
    public function form($id = null)
    {
        $id = (int) $id;
        if ($id && !$this->serviceProvider->getUserAuthService()->isAuthorized()) {
            $this->request->redirect('/');
        }

        $request = $this->request;
        $taskRepository = $this->serviceProvider->getRepositoryManager()->getTaskRepository();
        $pageTitle = $id ? 'Edit task' : 'Add task';

        $errors = [
            'userName' => null,
            'email' => null,
            'description' => null,
        ];
        if ($request->isPostRequest()) {
            $userName = $request->post('userName');
            $email = $request->post('email');
            $description = $request->post('description');

            $taskStatus = $request->post('status')
                ? new TaskStatus((int)$request->post('status'))
                : TaskStatus::NEW();

            $taskImage = null;
            if ($id) {
                $originTask = $taskRepository->getById($id);
                $taskImage = $originTask->getImage();
            }

            $task = new TaskDto(
                $id,
                $userName,
                $email,
                $description,
                $taskStatus,
                $taskImage
            );

            $validationRules = [
                new RuleNotEmptyString('userName', $userName),
                new RuleEmail('email', $email),
                new RuleNotEmptyString('description', $description),
            ];

            if ($this->validator->validate(...$validationRules)) {
                $imageData = $request->post('image');
                if ($imageData) {
                    $imageUrl = $this->serviceProvider->getImageService()->storeFormDataUrl(
                        '/tasks',
                        $imageData
                    );
                    $task->setImage($imageUrl);
                }
                $taskRepository->save($task);
                $request->redirect('/');
            } else {
                $errors = array_merge($errors, $this->validator->getErrors());
            }
        } else {
            if ($id) {
                $task = $taskRepository->getById($id);
            } else {
                $task = new TaskDto(
                    null,
                    '',
                    '',
                    '',
                    TaskStatus::NEW(),
                    ''
                );
            }
        }

        $textFields = [
            'userName' => [
                'value' => $task->getUserName(),
                'error' => $errors['userName'],
                'placeholder' => 'Enter user name',
            ],
            'email' => [
                'value' => $task->getEmail(),
                'error' => $errors['email'],
                'placeholder' => 'Enter email',
            ],
            'description' => [
                'value' => $task->getDescription(),
                'error' => $errors['description'],
                'placeholder' => 'Enter description',
            ],
        ];

        $this->clientScript->registerJsFile('taskForm');
        $this->clientScript->registerJsFile('ImageHelper');

        $this->view->withParam('pageTitle', $pageTitle)
            ->withParam('textFields', $textFields)
            ->withParam('task', $task)
            ->render('task/form');

    }
}
