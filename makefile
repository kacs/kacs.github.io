REMOTE=kalamba7@kalamazooacs.org:/home1/kalamba7/public_html/
CONFIG=_config.yml,_config-deploy.yml
BUILD=bundle exec jekyll build --config $(CONFIG)
BUILD_APACHE=bundle exec jekyll build --destination ../public_html/kacs/ --config _config.yml,_config-apache.yml

all: css/kacs.css
	$(BUILD)

css/kacs.css: css/kacs.less
	lessc --clean-css css/kacs.less css/kacs.css

deploy: all
	rsync -alvz --del _site/ $(REMOTE)

apache: css/kacs.css
	$(BUILD_APACHE)

serve:
	bundle exec jekyll serve --watch
