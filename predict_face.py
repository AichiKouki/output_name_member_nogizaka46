# -*- coding: utf-8 -*- 
from keras.models import load_model
from keras.preprocessing.image import ImageDataGenerator
from keras.preprocessing import image
import numpy as np
#変更点
rgb_image = './upload_after/uploadImage.jpg' 

#変更点
model = load_model('./trained_models/tiny_CNN_face.h5')

face_labels = ["秋元真夏","星野みなみ","齋藤飛鳥","白石麻衣"]
#load_imgを使い32ピクセルで画像を読み込む
img = image.load_img(rgb_image, target_size=(32, 32))
#img_to_arrayで画像をNumpy配列に変換する
x = image.img_to_array(img)
#np.extend_dimsで次元を増やして、255で割り正規化する
x = np.expand_dims(x, axis=0) / 255
#model.predict()メソッドを使い画像データxの推論を行う
face_predict = model.predict(x)#指定した画像の可能性を表す数値が入る
#{'akimoto': 0, 'hoshino': 1, 'saito': 2, 'shiraishi': 3}
#print(face_predict)
nameNumLabel=np.argmax(model.predict(x)) #np.argmaxは配列の最大要素を返す
#print("nameNumLabelは",nameNumLabel)
if nameNumLabel== 0: 
    print("akimoto")
elif nameNumLabel==1:
    print("hoshino")
elif nameNumLabel==2:
    print("saito_asuka")
elif nameNumLabel==3:
    print("shiraishi")
    
print(face_predict) #メンバーそれぞれの値を出力
