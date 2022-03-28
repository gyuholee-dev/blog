# 데이터베이스 전부 백업
$ mysqldump -u root gyuholee > gyuholee_20220329.dump

# 데이터베이스 전부 리스토어
$ mysql -u root gyuholee < gyuholee_20220329.dump