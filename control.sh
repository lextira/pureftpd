#!/bin/sh

usage() {
	# command help:
	echo "
### pureftp-api controller ###

up
    start the application

down
    start the applications

bash {service}
    start bash of container

exec {service} {command}
    execute command in service
	";
} # => usage()


up() {
	# command up:
	docker-compose up -d
} # => up()


down() {
	# command down:
	docker-compose down
} # => down()


exec_bash() {
	# command exec:
	docker-compose exec $1 /bin/bash;
} # => exec_bash()

exec_command() {
	# command exec:
	docker-compose exec -d $1 $2;
} # => exec_bash()

# get command name
cmd="$1"

# determine how we were called, then hand off to the function responsible
[ -n "$1" ] && shift # scrape off command
case "$cmd" in
	up)
		 up "$@"
		;;
    down)
		 down "$@"
		;;
    bash)
		 exec_bash "$@"
		;;

    exec)
		 exec_command "$@"
		;;
	""|help|-h|--help|--usage)
		usage "$1"
		exit 0
		;;
	*)
		echo "Unknown command '$cmd'. Run without commands for usage help."
		;;
esac