#-*- coding=utf8 -*-
import os
import shutil

src_path = "src"
dst_path = "new/static"
css_path = "css"
js_path  = "js"
img_path = "images"

for _file in os.listdir(src_path):
    src_file = src_path + "/" + _file
    if ".css" in _file:
        dst_file = dst_path + "/" + css_path + "/" + _file
    elif ".js" in _file:
        _ = _file.split(".js")[0] + ".js"
        dst_file = dst_path + "/" + js_path + "/" + _
    else:
        dst_file = dst_path + "/" + img_path + "/" + _file
    shutil.copy(src_file, dst_file)





