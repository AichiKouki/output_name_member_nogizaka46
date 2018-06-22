# coding: UTF-8
import os
import cv2
#OpenCVで顔画像を切り抜いて保存するプログラム
input_folder = "upload_before"#加工前の画像のディレクトリ
output_folder = "upload_after"#加工後に出力するディレクトリ
cascade_path = "./trained_models_opencv/haarcascade_frontalface_alt2.xml"
#listdirを利用してフォルダ内のファイルを取得し、OpenCVを利用して顔画像を切り出す
files = os.listdir("./" + input_folder + "/")

for i in range(0, len(files)):
    print (files[i])
    root, extension = os.path.splitext(files[i])
    if files[i] == ".DS_Store":
        print("This is no image.")
    elif extension == ".png" or ".jpeg" or ".jpg":
        portrait = "./" + input_folder + "/" + files[i]
        cv_image = cv2.imread(portrait)
        gray_image = cv2.cvtColor(cv_image, cv2.COLOR_BGR2GRAY)
        cascade = cv2.CascadeClassifier(cascade_path)

        facerect = cascade.detectMultiScale(gray_image, scaleFactor=1.1, minNeighbors=2, minSize=(150, 150))

        if len(facerect) > 0:
            for rect in facerect:
                x, y, w, h = rect[0], rect[1], rect[2], rect[3]
                dst = cv_image[y:y + h, x:x + w]
            dst = cv2.resize(dst, (150, 150))
            #cv2.imwrite("./" + output_folder + "/" + output_folder + "_" + str(i + 1) + ".jpg", dst)
            cv2.imwrite("./" + output_folder + "/" + "uploadImage" + ".jpg", dst)
            print("crop done > " + output_folder + "_" + str(i + 1) + ".jpg")

        else:
            print("can't crop")
