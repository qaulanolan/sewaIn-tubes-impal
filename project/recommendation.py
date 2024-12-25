from flask import Flask, jsonify, request
import mysql.connector
import random

app = Flask(__name__)

# Database connection
db_config = {
    'host': 'localhost',
    'user': 'root',
    'password': '',
    'database': 'home_db'
}

@app.route('/recommendations', methods=['GET'])
def get_recommendations():
    user_id = request.args.get('user_id')
    connection = mysql.connector.connect(**db_config)
    cursor = connection.cursor(dictionary=True)

    cursor.execute("""
        SELECT id, product_name, price, type, image_01 
        FROM product 
        WHERE click_count > 0
        ORDER BY click_count DESC 
        LIMIT 3
    """)

    recommendations = cursor.fetchall()
    connection.close()

    return jsonify(recommendations)



if __name__ == '__main__':
    app.run(debug=True, host='0.0.0.0', port=5000)
