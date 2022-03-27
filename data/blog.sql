/* 참고
https://sql-factory.tistory.com/2063
https://blueamor.tistory.com/618

-- 최소일 경우 블로그 테이블만.
-- 블로그, 보드, 코멘트 각각 테이블 필요
-- 제대로 만들 경우: 관리, 유저, 카테고리, 포스트, 코멘트 등등 필요


/* post 포스트
idx 인덱스: 자동증가 정수
wdate 날짜: 타임스탬프
title 타이틀
writer 이름
category 분류: profile, portpolio...
posttype: text, media, link...
file 파일
link 링크
content 내용
tags 태그(차후 추가)
*/

CREATE TABLE post (
  idx INT AUTO_INCREMENT,
  wdate INT,
  title VARCHAR(80),
  writer VARCHAR(20),
  category VARCHAR(20),
  posttype VARCHAR(20),
  file VARCHAR(80),
  link VARCHAR(80),
  content TEXT,
  tags VARCHAR(80),
  pinned BOOLEAN NOT NULL DEFAULT FALSE,
  PRIMARY KEY (idx)
);

ALTER TABLE post ADD pinned BOOLEAN NOT NULL DEFAULT FALSE;
UPDATE post SET pinned = TRUE WHERE idx = 1;

ALTER TABLE post ADD tags VARCHAR(80);
UPDATE post SET tags = '태그1,태그2,태그3,태그4';

/* board 보드
idx 인덱스: 자동증가 정수
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
idx 인덱스
wdate 날짜
name 이름
pwd 비밀번호
content 내용
비밀
*/
