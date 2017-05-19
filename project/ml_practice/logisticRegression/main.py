def main():
    from mylogis import MyLogis
    import os.path
    from sklearn import cross_validation
    from sklearn.linear_model import LogisticRegression
    from sklearn.metrics import accuracy_score


    dataClass = MyLogis('data/iris.data')
    dataset = dataClass.dataset

    print(dataset.describe())
    print(dataset.groupby('class').size())

    array = dataset.values
    x = array[:,0:4]
    y = array[:,4]

    x_train, x_test, y_train, y_test = cross_validation.train_test_split(x, y, test_size=0.2, random_state=0)

    model = LogisticRegression(penalty='l2')
    model.fit(x_train, y_train)
    result = model.predict(x_test)
    print(accuracy_score(y_test, result))

    print(model.predict([[10.0,2.2,5.0,0]]))


if __name__ == '__main__':
    main()
