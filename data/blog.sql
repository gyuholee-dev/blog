/* 참고
https://sql-factory.tistory.com/2063
https://blueamor.tistory.com/618

-- 최소일 경우 블로그 테이블만.
-- 블로그, 보드, 코멘트 각각 테이블 필요
-- 제대로 만들 경우: 관리, 유저, 카테고리, 포스트, 코멘트 등등 필요


/* post 포스트
postid 인덱스: 자동증가 정수
wdate 날짜: 타임스탬프
title 타이틀
writer 이름
category 분류: profile, portpolio...
posttype: text, media, link...
file 파일
link 링크
content 내용
tags 태그(차후 추가)
pinned 상단고정
allow 권한: ????
*/

CREATE TABLE post (
  postid INT AUTO_INCREMENT PRIMARY KEY,
  wdate INT,
  title VARCHAR(80),
  writer VARCHAR(20),
  category VARCHAR(20),
  posttype VARCHAR(20),
  file VARCHAR(80),
  link VARCHAR(80),
  content TEXT,
  tags VARCHAR(80),
  pinned BOOLEAN NOT NULL DEFAULT FALSE
);

/* user 유저
userid 아이디
password 비밀번호
username 이름
email 이메일
avatar 아바타
link 링크
usergroup 권한그룹: admin, user
*/

CREATE TABLE user (
  userid VARCHAR(20) NOT NULL PRIMARY KEY,
  password VARCHAR(20),
  username VARCHAR(20),
  email VARCHAR(30),
  avatar VARCHAR(80),
  link VARCHAR(80),
  usergroup VARCHAR(20) DEFAULT 'user'
);

/* board 보드
threadid 인덱스: 자동증가 정수
wdate 날짜: 타임스탬프
title 타이틀
writer 이름
email 이메일
home 홈페이지
pass 비밀번호
ip 작성자 IP
category 카테고리: profile, portpolio...
posttype: text, media, link...
tags 태그 
files 파일
content 내용
*/

CREATE TABLE board (

);

/* comment 덧글
commentid 인덱스
wdate 날짜
name 이름
pwd 비밀번호
content 내용
비밀
*/
