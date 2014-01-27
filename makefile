REMOTE=kalamba7@kalamazooacs.org:/home1/kalamba7/public_html/
RSYNC=rsync -alvz --del _site/ $(REMOTE)
CONFIG=_config.yml,_config-deploy.yml
LESS=lessc
BUILD=bundle exec jekyll build --config $(CONFIG)
BUILD_APACHE=bundle exec jekyll build --destination ../public_html/kacs/ --config _config.yml,_config-apache.yml
SERVE=bundle exec jekyll serve --watch

all: css/kacs.css
	$(BUILD)

css/kacs.css: css/kacs.less
	$(LESS) css/kacs.less css/kacs.css

deploy: all
	$(RSYNC)

apache: css/kacs.css
	$(BUILD_APACHE)

serve:
	$(SERVE)
