# スパークル

## Technology
### Backend
- [PHP](https://www.w3schools.com/php/)
- [Laravel](https://laravel.com/docs/9.x) API framework
- [Laravel Action Classes](https://laravel-news.com/organize-laravel-applications-with-actions) Design pattern
- [Dependence Injection](https://www.tutorialspoint.com/what-is-dependency-injection-in-php)
- [Repository pattern](https://dev.to/safventure11000/implement-crud-with-laravel-service-repository-pattern-1dkl)
- [Laravel Swagger](https://github.com/DarkaOnLine/L5-Swagger) to create API document
- [Laravel JWT](https://blog.logrocket.com/implementing-jwt-authentication-laravel-9)
- [Laravel pint](https://laravel.com/docs/10.x/pint) to format code
- [MS SQL Server](https://learn.microsoft.com/en-us/sql/sql-server/tutorials-for-sql-server-2016?view=sql-server-ver16) Database
- [Docker](https://www.docker.com/)

### Frontend
- [Vue3](https://vuejs.org/guide/typescript/overview) with typescript
- [Pinia](https://pinia.vuejs.org/introduction.html) state management
- [axios](https://axios-http.com/docs/intro) to call API
- [lodash](https://lodash.com/)
- [moment](https://momentjs.com/)

## Git Flow
- Step 1: Change task to In progress
- Step 2: checkout to staging, pull newest code from staging
    ```
    git checkout staging
    git pull origin staging
    ```
- Step 3: Create branch for task, base in branch `staging`

    **Rule of branch name:**
    - If issue is `'Task'`, branch name start with `task/`
    - If issue is `'Feature'`, branch name start with `feat/`
    - If issue is `'Bug'`, branch name start with `fix/`
    - After that, concat with string `spkl-[issueId]`

    Example: Issue is `Feature`, Id is `123`, Name is `Create Page login`. Branch name is `feat/spkl-123`
    ```
    git checkout -b feat/spkl-123 staging
    ```
- Step 4: When commit, message of commit follow rule
    - If issue is `'Task'`, branch name start with `task: `
    - If issue is `'Feature'`, branch name start with `feat: `
    - If issue is `'Bug'`, branch name start with `fix: `
    - Next is string `[SPKL-[issueId]]`
    - Next is commit content

    Example: `feat: [SPKL-123] Coding layout for page login`
- Step 5: When create merge request
    - Create merger request to branch `develop` first
    - After tested done, when deliver, create merge request to branch `staging`
    
    **Rule of merge request name:**
    - If issue is `'Task'`, title start with `task: `
    - If issue is `'Feature'`, title start with `feat: `
    - If issue is `'Bug'`, title start with `fix: `
    - Start with `[Branch][SPKL-[issueId]]`
    - Next is  merge request content

        Example: `feat: [develop][SPKL-123] Page login`

    **<span style="color: #dc3545;">Rule of merge request description:</span>**
    - In **`What does this MR do and why?`**, replace _`Describe in detail what your merge request does and why.`_ with your content of this merge request
    - In **`Screenshots or screen recordings`**, replace _`These are strongly recommended to assist reviewers and reduce the time to merge your change.`_ with screen recordings of feature or task for this merge request
    - Check the checklist
    - Select approver
    - Select merger

    **<span style="color: #dc3545;">Rule fix conflict or merge newest code:</span>**
    - Create other branch with convention like step 3. But have suffixes `-dev`, `-dev1`,... (in example, branch name is `feat/spkl-123-dev`)
    - After that, merge coding branch to new branch. In example is merger branch `feat/spkl-123` to branch `feat/spkl-123-dev`
        ```
        git merge feat/spkl-123
        ```
    - Fix conflict and create merge request to `develop`

**Note:** `[issueId]` is id of task in redmine, or can get from task of [PMO](http://117.2.155.30:8999/) or [Backlog](https://ans-sp.backlog.com/find/SPARKLEANS?projectId=480454&statusId=1&statusId=2&statusId=3&statusId=195113&statusId=195114&sort=UPDATED&order=false&simpleSearch=true&allOver=false&offset=0)

## Run project with Docker
1. Prepare
    - Install Docker desktop on your PC ( https://www.docker.com/products/docker-desktop )
    - If it running on Windows OS, switch to Linux OS
    - Create file `./01_API/.env` for API, refer `./01_API/.env.example`
    - Create file `./02_WEB/.env` for API, refer `./02_WEB/env_example`
2. Build
    - Open cmd/shell in root folder
    - Run command: *`docker-compose build`* for build image
    - Run command: *`docker-compose up -d`* for start db and web service
    - Web API running default on: **http://localhost:9019/api/documentation**
    - Web View running default on: **http://localhost:9020**
3. Note
    - If wanna to change port of web service, go to file docker-compose.yml and change port of web service
	- If you need to run command line in API, run this: *`docker exec -it spkl_api bash`* or *`docker-compose exec spkl_api <command>`*
    - If you need to run command line in WEB, run this: *`docker exec -it spkl_web bash`* or *`docker-compose exec spkl_web <command>`*
4. Account
    - API: defined in file `.env`

## Visual studio code Extensions
- Vue 3 extension pack
- Laravel Extension Pack
- GitLens
- Git Graph

## Wiki

### Backend
- [AnsService](/wiki/backend/AnsService.md)
- [IdentityService](/wiki/backend/IdentityService.md)
### Frontend
- [ansCommon](/wiki/frontend/ansCommon.md)
- [ansNumber](/wiki/frontend/ansNumber.md)
- [ansDateTime](/wiki/frontend/ansDateTime.md)
- [ansValidate](/wiki/frontend/ansValidate.md)
- components
    - [AnsInput](/wiki/frontend/components/AnsInput.md)