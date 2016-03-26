all: test upload

test:
	dev_appserver.py .

upload:
	appcfg.py -A everfocuscodechallenge update .
