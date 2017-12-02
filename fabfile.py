from fabric.api import task, env
from fabric.operations import local, _shell_escape
import os
from sys import platform


@task
def start():
    """Be sure that everything is started and installed"""
    if not os.path.exists('./.env'):
        local('cp .env.dist .env')

    up()
    cache_clear()
    install()
    update_schema()


@task
def restart_service(service):
    """Restart a single service"""
    docker_compose('restart %s' % (service))


@task
def up():
    """Ensure infrastructure is sync and running"""
    docker_compose('build')
    docker_compose('up --remove-orphans -d')


@task
def stop():
    """Stop the infrastructure"""
    docker_compose('stop')


@task
def logs():
    """Show logs of infrastructure"""
    docker_compose('logs -f --tail=150')


@task
def install():
    """Install frontend application (composer, yarn, assets)"""
    docker_compose_run('composer install', 'builder', 'chubbycoon')
    docker_compose_run('yarn install --force', 'builder', 'chubbycoon')
    docker_compose_run('yarn dev', 'builder', no_deps=True)


@task
def update():
    """Install frontend application (composer, yarn, assets)"""
    docker_compose_run('composer update', 'builder', 'chubbycoon')


@task
def webpack_watch():
    """ webpack frontend watcher"""
    docker_compose_run('yarn watch', 'builder', no_deps=True)


@task
def webpack_prod():
    """ frontend package for production"""
    docker_compose_run('yarn build', 'builder', no_deps=True)


@task
def cs_fix(dry_run=False):
    """Fix coding standards in code"""
    if dry_run:
        docker_compose_run('php-cs-fixer fix --config=.php_cs --dry-run --diff', 'builder', 'chubbycoon')
    else:
        docker_compose_run('php-cs-fixer fix --config=.php_cs', 'builder', 'chubbycoon')


@task
def cache_clear():
    """Clear cache of the frontend application"""
    docker_compose_run('rm -rf var/cache/', 'builder', 'root', no_deps=True)


@task
def update_schema():
    """Update database schema"""
    docker_compose_run('php bin/console doctrine:database:create --if-not-exists', 'builder', 'chubbycoon', no_deps=True)
    docker_compose_run('php bin/console doctrine:schema:update --force --dump-sql', 'builder', 'chubbycoon', no_deps=True)


@task
def generate_migration():
    """Update database schema"""
    docker_compose_run('php bin/console doctrine:migrations:diff', 'builder', 'chubbycoon', no_deps=True)


@task
def fixtures():
    """Import fixtures into database"""
    docker_compose_run('php bin/console doctrine:database:drop --force', 'builder', 'chubbycoon', no_deps=True)
    update_schema()
    print('TODO');

@task
def ssh():
    """Ssh into frontend container"""
    docker_compose('exec --user=chubbycoon --index=1 frontend /bin/bash')


@task
def builder():
    """Bash into a builder container"""
    docker_compose_run('bash', 'builder', 'chubbycoon')


def docker_compose(command_name):
    local('CHUBBYCOON_UID=%s docker-compose -p chubbycoon %s %s' % (
        env.uid,
        ' '.join('-f infrastructure/dev/' + file for file in env.compose_files),
        command_name
    ))


def docker_compose_run(command_name, service, user="chubbycoon", no_deps=False):
    args = [
        'run '
        '--rm '
        '-u %s ' % _shell_escape(user)
    ]

    if no_deps:
        args.append('--no-deps ')

    docker_compose('%s %s /bin/bash -c "%s"' % (
        ' '.join(args),
        _shell_escape(service),
        _shell_escape(command_name)
    ))


env.compose_files = ['docker-compose.yml']
env.uid = int(local('id -u', capture=True))
env.root_dir = os.path.dirname(os.path.abspath(__file__))


if env.uid > 256000:
    env.uid = 1000

