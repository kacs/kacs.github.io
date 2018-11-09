REMOTE=mwolf@simon.artiosonline.com:/srv/kacs/
CONFIG=_config.yml,_config-deploy.yml
# BUILD=jekyll build --config $(CONFIG)
JEKYLL=bundle exec jekyll
# BUILD=bundle exec jekyll

all: css/kacs.css
	$(JEKYLL) build --config $(CONFIG)

css/kacs.css: css/kacs.less
	lessc --verbose --clean-css css/kacs.less css/kacs.css	

deploy: all
	s3_website push

serve: css/kacs.css
	$(JEKYLL) serve --watch
