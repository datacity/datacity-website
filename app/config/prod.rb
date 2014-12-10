server 'datacity-web@datacity.montpellierlab.fr', :app, :web, :primary => true

set :deploy_to, '/home/datacity-web'
set :use_set_permissions, true
set :user, "datacity-web"
