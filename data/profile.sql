/*
 프로필 데이터
*/

-- 프로필
INSERT INTO post 
(wdate, title, writer, category, subcategory, posttype, files, link, content) 
VALUES (
  UNIX_TIMESTAMP(),
  '이규호의 프로필',
  'LeeGyuho',
  'profile',
  '',
  'text',
  'BI-header_r.png',
  '',
  'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempore molestiae architecto repellat eligendi, iusto magnam illum deserunt cumque unde voluptatibus tenetur nisi expedita doloremque quasi aliquid suscipit, temporibus omnis labore?'
);

---------------------------- 링크 (네개) ----------------------------

INSERT INTO post 
(wdate, title, writer, category, subcategory, posttype, files, link, content) 
VALUES (
  UNIX_TIMESTAMP(),
  'GITHUB',
  'LeeGyuho',
  'profile',
  'link',
  'link',
  'images(3).jpg',
  'https://github.com/leegyuho-dev',
  '깃허브 링크'
);

INSERT INTO post 
(wdate, title, writer, category, subcategory, posttype, files, link, content) 
VALUES (
  UNIX_TIMESTAMP(),
  'ART & GRAPHIC',
  'LeeGyuho',
  'profile',
  'link',
  'link',
  'images(2).jpg',
  'https://www.artstation.com/geoflowerstudio',
  '아트스테이션 링크'
);

INSERT INTO post 
(wdate, title, writer, category, subcategory, posttype, files, link, content) 
VALUES (
  UNIX_TIMESTAMP(),
  'DEVELOPMENT',
  'LeeGyuho',
  'profile',
  'link',
  'link',
  'images(1).jpg',
  'view.php?page=portpolio',
  '포트폴리오 페이지 링크'
);

INSERT INTO post 
(wdate, title, writer, category, subcategory, posttype, files, link, content) 
VALUES (
  UNIX_TIMESTAMP(),
  'PROFILE',
  'LeeGyuho',
  'profile',
  'link',
  'link',
  'BI-header_r.png',
  'view.php?page=profile',
  '프로필 페이지 링크'
);