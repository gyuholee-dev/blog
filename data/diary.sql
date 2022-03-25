/*
 다이어리 데이터
*/

INSERT INTO post 
(wdate, title, writer, category, subcategory, posttype, files, link, content) 
VALUES (
  UNIX_TIMESTAMP(),
  '어제 일기',
  'LeeGyuho',
  'diary',
  '',
  'text',
  '',
  '',
  'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempore molestiae architecto repellat eligendi, iusto magnam illum deserunt cumque unde voluptatibus tenetur nisi expedita doloremque quasi aliquid suscipit, temporibus omnis labore?'
);

INSERT INTO post 
(wdate, title, writer, category, subcategory, posttype, files, link, content) 
VALUES (
  UNIX_TIMESTAMP(),
  '어제 사진',
  'LeeGyuho',
  'diary',
  '',
  'media',
  'images(4).jpg',
  '',
  '사진설명 사진설명 사진설명 사진설명 사진설명 사진설명 사진설명 사진설명'
);

INSERT INTO post 
(wdate, title, writer, category, subcategory, posttype, files, link, content) 
VALUES (
  UNIX_TIMESTAMP(),
  '오늘 일기',
  'LeeGyuho',
  'diary',
  '',
  'text',
  '',
  '',
  'Lorem, ipsum dolor sit amet consectetur adipisicing elit. Tempore molestiae architecto repellat eligendi, iusto magnam illum deserunt cumque unde voluptatibus tenetur nisi expedita doloremque quasi aliquid suscipit, temporibus omnis labore?'
);

INSERT INTO post 
(wdate, title, writer, category, subcategory, posttype, files, link, content) 
VALUES (
  UNIX_TIMESTAMP(),
  '오늘 사진',
  'LeeGyuho',
  'diary',
  '',
  'media',
  'images(4).jpg',
  '',
  '사진설명 사진설명 사진설명 사진설명 사진설명 사진설명 사진설명 사진설명'
);

INSERT INTO post 
(wdate, title, writer, category, subcategory, posttype, files, link, content) 
VALUES (
  UNIX_TIMESTAMP(),
  '오늘 영상',
  'LeeGyuho',
  'diary',
  '',
  'media',
  'cat-typing.gif',
  '',
  '영상설명 영상설명 영상설명 영상설명 영상설명 영상설명 영상설명 영상설명'
);