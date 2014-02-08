#VM Debian
server 'datacity-web@debian-grp6.labeip.epitech.eu', :app, :web, :primary => true

set :deploy_to, '/home/datacity-web'
set :use_set_permissions, true
set :user, "datacity-web"
