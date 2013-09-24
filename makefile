REMOTE=kalamba7@kalamazooacs.org:/home1/kalamba7/public_html/
RSYNC=rsync -alvz --del _site/ $(REMOTE)
CONFIG=_config.yml,_config-deploy.yml
BUILD=jekyll build --config $(CONFIG)

all:
	$(BUILD)

deploy: all
	$(RSYNC)
