mediawiki-sandstorm
===================

This Sandstorm app uses docker to build it's package.

* You must have docker v1.1+ installed.
* First run `docker build -t mediawiki .` to build the docker image
* Then you will need to run the image with `docker run -p 33411:33411 --dns='127.0.0.1' -i -t mediawiki /sbin/my_init -- /bin/bash`
* Exit this image after it has booted up and run the app successfully. Then run `./export_docker.sh` from this directory to export the last run docker container into a folder named `dockerenv`.
* Once this is done, `spk dev` and `spk pack` should now work like normal
