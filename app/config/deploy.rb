set :stages,        %w(prod dev demo)
set :default_stage, "prod"
set :stage_dir,     "app/config"
require 'capistrano/ext/multistage'

set :application, "Datacity_website"
#set(:deploy_to) { "#{spec_deploy_to}" }
set :app_path,    "app"

set :repository,  "git@github.com:Wykks/Datacity.git"
set :scm,         :git
set :branch,      "dev"
# Or: `accurev`, `bzr`, `cvs`, `darcs`, `subversion`, `mercurial`, `perforce`, or `none`

set :deploy_via, :remote_cache

set :model_manager, "doctrine"
# Or: `propel`

set  :use_sudo,      false
set  :keep_releases,  3

set :shared_files,      ["app/config/parameters.yml"]
set :shared_children,     [app_path + "/logs", web_path + "/uploads", "vendor"]
set :use_composer, true
set :update_vendors, false

set :writable_dirs,     ["app/cache", "app/logs"]
#set(:webserver_user)    { "#{spec_user}" }
#set(:user)              { "#{spec_user}" }
set :permission_method, :acl

ssh_options[:forward_agent] = true

set :dump_assetic_assets, true
set :assets_symlinks, true
# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL

before 'symfony:composer:install', 'symfony:bower:install'
after "deploy", "symfony:clear_apc"
after "deploy:rollback:cleanup", "symfony:clear_apc"

namespace :symfony do
  desc "Clear apc cache"
  task :clear_apc do
    capifony_pretty_print "--> Clear apc cache"
    run "#{try_sudo} sh -c 'cd #{latest_release} && #{php_bin} #{symfony_console} apc:clear #{console_options}'"
    capifony_puts_ok
  end
end

namespace :symfony do
      namespace :bower do
      desc '[internal] Run the bower install'
      task :install do
        capifony_pretty_print "--> Installing Bower dependencies"
        invoke_command "cd #{latest_release} && bower install", :via => run_method
        capifony_puts_ok
      end
    end
end
