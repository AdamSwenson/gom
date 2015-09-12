# config valid only for current version of Capistrano
lock '3.4.0'

set :application, 'gradeomatic'

set :repo_url, 'git@bitbucket.org:merpCo/gradeomatic3.git'

# Default branch is :master
# ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# Default deploy_to directory is /var/www/my_app_name
set :deploy_to, '/var/www/gradeomatic.net'

# Default value for :scm is :git
# set :scm, :git

# Default value for :format is :pretty
# set :format, :pretty

# Default value for :log_level is :debug
# set :log_level, :debug

# Default value for :pty is false
# set :pty, true

# Default value for :linked_files is []
# set :linked_files, fetch(:linked_files, []).push('config/database.yml', 'config/secrets.yml')

# Default value for linked_dirs is []
# set :linked_dirs, fetch(:linked_dirs, []).push('log', 'tmp/pids', 'tmp/cache', 'tmp/sockets', 'vendor/bundle', 'public/system')

# Default value for default_env is {}
# set :default_env, { path: "/opt/ruby/bin:$PATH" }

# Default value for keep_releases is 5
# set :keep_releases, 5

set :action_path, "/var/www/gradeomatic.net/current"

set :laravel_roles, :all
set :laravel_artisan_flags, "--env=production"
set :laravel_server_user, "www-data"

namespace :deploy do
    #change owner of templates back to nico
    after :updated,:build do
        on roles :all do
            execute :mv, "#{release_path}/public #{release_path}/public_html"
        end
    end
end





