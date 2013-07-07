#The same for now
server 'datacity-web@vps28072.ovh.net', :app, :web, :primary => true

set :deploy_to, '/home/datacity-web'
set :use_set_permissions, false
set :user, "datacity-web"
