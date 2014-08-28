REMOTE=kalamba7@kalamazooacs.org:/home1/kalamba7/public_html/
CONFIG=_config.yml,_config-deploy.yml
BUILD=jekyll build --config $(CONFIG)

all: css/kacs.css
	$(BUILD)

css/kacs.css: css/kacs.less
	lessc --clean-css css/kacs.less css/kacs.css

deploy: all
	rsync -alvz --del _site/ $(REMOTE)

serve:
	jekyll serve --watch
