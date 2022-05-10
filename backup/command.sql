# 데이터베이스 전부 백업
$ mysqldump -u root blog > C:\Workspaces\blog\backup\blog_20220510.dump

# 데이터베이스 전부 리스토어
$ mysql -u root blog < C:\Workspaces\blog\backup\blog_20220510.dump