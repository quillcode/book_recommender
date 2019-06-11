from http.server import HTTPServer, BaseHTTPRequestHandler
from urllib.parse import urlparse
from urllib.parse import parse_qs
import pandas as pd
import numpy as np

ratingMatrix = None
average_rating_isbn = None
ratings = None
def createMatrix():
    global ratingMatrix
    global average_rating_isbn
    global ratings
    ratings = pd.read_csv("BX-Book-Ratings.csv", sep=';', error_bad_lines=False, encoding="latin-1") 
    # print(ratings)
    average_rating_isbn = pd.DataFrame(ratings.groupby('ISBN')["Book-Rating"].mean()) # find mean for each isbn separately.
    # print(average_rating_isbn)
    average_rating_isbn["ratingCount"] = pd.DataFrame(ratings.groupby('ISBN')["Book-Rating"].count()) # How much each book is rated.
    # print(average_rating_isbn["ratingCount"])
    # thresholding
    # userCounts = ratings["User-ID"].value_counts() 
    # ratings = ratings[ratings["User-ID"].isin(userCounts[userCounts > 100 ].index)]
    # rateCounts = ratings["ISBN"].value_counts() 
    # ratings = ratings[ratings["ISBN"].isin(rateCounts[rateCounts>20].index)]
    # create rating matrix

    ratingMatrix = ratings.pivot_table(values="Book-Rating", index="User-ID", columns="ISBN")

    # print(ratingMatrix)




def recommand(isbn):
    print(str(isbn, 'latin-1'))
    global average_rating_isbn
    bones_ratings = ratingMatrix[int(str(isbn, 'utf-8'))]
    # bones_ratings = ratingMatrix[int('1118008189')]
    # print(bones_ratings)
    similar_to_bones = ratingMatrix.corrwith(bones_ratings)
    corr_bones_Df = pd.DataFrame(similar_to_bones, columns=["personR"])

    # corr_bones_Df.dropna(inplace=True)
    
    corr_summary = corr_bones_Df.join(average_rating_isbn["ratingCount"])
    corr_summary = corr_summary.sort_values(by=['personR', 'ratingCount'], ascending=False)
    headRows = corr_summary.head(4)
    return headRows

def getMostPopular():
    # global average_rating_isbn
    global ratings

    average_rating_isbn = pd.DataFrame(ratings.groupby('ISBN')["Book-Rating"].mean()) # find mean for each isbn separately.
    headRows = average_rating_isbn.sort_values(["Book-Rating"], ascending=False).head(3) 
    return headRows
    

class SimpleHTTPRequestHandler(BaseHTTPRequestHandler): # its parameter is class our class extends basehttprequesthandler class

    def do_GET(self):
            parsed = urlparse(self.path) # get the path 
            url = parsed[2];
            obj = parse_qs(parsed.query) # in parse_qs the data is sent (data after ? is sent separated by &)
            value = obj.get('isbn',' ')  # to get the value of isbn and if there is no isbn in the obj then return empty string.
            rows = ''
            if len(value[0]) < 2 and url != '/favicon.ico':
                # get the most rated books
                rows = getMostPopular()

                csvStr = ''
                for row in rows.iterrows():
                    csvStr+= str(row[0])+' ,'
                self.send_response(200) #successful response to client.
                self.send_header('Content-type','text/plain; charset=utf-8')
                self.end_headers()
                self.wfile.write(csvStr.encode('utf-8'))

            elif len(value[0]) > 2 :
                isbnStr = value[0].encode('utf-8')
                rows = recommand(isbnStr)

                csvStr = ''
                for row in rows.iterrows():
                    csvStr+= str(row[0])+' ,'
                self.send_response(200) #successful response to client.
                self.send_header('Content-type','text/plain; charset=utf-8')
                self.end_headers()
                self.wfile.write(csvStr.encode('utf-8'))
                print(csvStr.encode('utf-8'))

           
            # csvStr = ''
            # for row in rows.iterrows():
            #     csvStr+= row[0]+' ,'
            # self.send_response(200) #successful response to client.
            # self.send_header('Content-type','text/plain; charset=utf-8')
            # self.end_headers()
            # self.wfile.write(csvStr.encode('utf-8'))


def run():
    print('the matrix is being created...')
    createMatrix()
    print('the matrix has completed.')

    print('the server is startig...')
    httpd = HTTPServer(('localhost', 8000), SimpleHTTPRequestHandler)
    print('the server is running...')
    httpd.serve_forever()

if __name__ == '__main__':
    run()
