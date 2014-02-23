set :stages,        %w(prod dev demo)
set :default_stage, "prod"
set :stage_dir,     "app/config"
require 'capistrano/ext/multistage'

set :application, "Datacity_website"
#set(:deploy_to) { "#{spec_deploy_to}" }
set :app_path,    "app"

set :repository,  "git@github.com:Wykks/Datacity.git"
set :scm,         :git
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

set :dump_assetic_assets, true
set :assets_symlinks, true
# Be more verbose by uncommenting the following line
# logger.level = Logger::MAX_LEVEL
