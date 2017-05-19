import pandas
import sklearn

class MyLogis:
    def __init__(self, filename):
        self.dataset = self.load(filename)

    def load(self, file):
        return pandas.read_csv(file)

    def showLog(self):
        print(self.dataset.shape)
