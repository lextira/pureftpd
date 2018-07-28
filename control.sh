#!/bin/sh

usage() {
	# command help:
	echo "
### pureftp-api controller ###

up
    start the application

down
    start the applications

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


dc_exec() {
	# command exec:
	docker-compose exec $2 $3
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
    exec)
		 dc_exec "$@"
		;;
	""|help|-h|--help|--usage)
		usage "$1"
		exit 0
		;;
	*)
		echo "Unknown command '$cmd'. Run without commands for usage help."
		;;
esac