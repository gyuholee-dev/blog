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
  posttype CHAR(10),
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
  nickname VARCHAR(20),
  email VARCHAR(30),
  avatar VARCHAR(80),
  link VARCHAR(80),
  usergroup VARCHAR(20) DEFAULT 'user'
);

/* board 보드
numb 인덱스: 자동증가 정수
wdate 날짜: 타임스탬프
title 타이틀
writer 이름
category 분류: notice, general...
content 내용
secret 비밀글
hits 조회수
*/

CREATE TABLE board (
  idx INT AUTO_INCREMENT PRIMARY KEY,
  category CHAR(10),
  wdate INT,
  userid CHAR(20),
  nickname VARCHAR(20),
  content VARCHAR(140),
  secret BOOLEAN DEFAULT 0
);

INSERT INTO board 
(category, title, wdate, userid, nickname, content)
VALUES
('notice', '공지사항 제목입니다', UNIX_TIMESTAMP(), 'gyuholee', 'Gyuholee', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque fuga commodi obcaecati delectus quaerat earum ad odit ducimus placeat doloremque corporis modi quia, harum cum exercitationem, veritatis velit aliquid nam.');
INSERT INTO board 
(category, title, wdate, userid, nickname, content)
VALUES
('general', '공지사항 제목입니다', UNIX_TIMESTAMP(), 'gyuholee', 'Gyuholee', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Atque fuga commodi obcaecati delectus quaerat earum ad odit ducimus placeat doloremque corporis modi quia, harum cum exercitationem, veritatis velit aliquid nam.');


/*
 board
 forum
 discussion
 thread
 reply

thread 쓰레드
  threadid 쓰레드 인덱스
  wdate 작성일
  userid 작성자 id
  nickname 작성자 이름
  content 본문
  threadtype 타입: thread, comment, reply,
  parent 부모(comment일 경우 postid, reply 일 경우 threadid) 
  child 자식(threadid)
  pinned 최상위 표시, type 이 thread 일 경우에만 적용
  secret 비밀글, 부모가 비밀일 경우 자동으로 적용, 이외 선택.
*/

CREATE TABLE thread (
  threadid INT AUTO_INCREMENT PRIMARY KEY,
  wdate INT,
  userid CHAR(20),
  nickname VARCHAR(20),
  content VARCHAR(140),
  threadtype CHAR(10) DEFAULT 'thread',
  parent INT,
  child INT,
  pinned BOOLEAN NOT NULL DEFAULT FALSE
  secret BOOLEAN NOT NULL DEFAULT FALSE
);


