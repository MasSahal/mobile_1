import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert';

class FoodPriceList extends StatefulWidget {
  const FoodPriceList({super.key});

  @override
  // ignore: library_private_types_in_public_api
  _FoodPriceListState createState() => _FoodPriceListState();
}

class _FoodPriceListState extends State<FoodPriceList> {
  List<dynamic> foodList = [];

  Future<void> fetchFoodData() async {
    final response =
        await http.get(Uri.parse('http://example.api.isibi.web.id'));

    if (response.statusCode == 200) {
      setState(() {
        foodList = json.decode(response.body);
      });
    } else {
      throw Exception('Gagal mengambil data dari API');
    }
  }

  @override
  void initState() {
    super.initState();
    fetchFoodData();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Daftar Harga Makanan'),
      ),
      body: ListView.builder(
        itemCount: foodList.length,
        itemBuilder: (BuildContext context, int index) {
          final food = foodList[index];
          return Card(
            child: ListTile(
              title: Text(food['name']),
              subtitle: Text(food['price']),
              // Anda dapat menambahkan widget lain sesuai kebutuhan, seperti gambar makanan, deskripsi, dll.
            ),
          );
        },
      ),
    );
  }
}
